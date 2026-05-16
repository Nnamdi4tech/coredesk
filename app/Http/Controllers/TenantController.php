<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TenantController extends Controller
{
    // check if subdomain exist here or not function start here. 
    public function checkSubdomain(Request $request)
    {
        if (!$request->school_name) {
            return response()->json([
                'suggestions' => [],
                'exists' => false
            ]);
        }

        $name = strtolower(preg_replace('/[^a-z0-9]+/', '', $request->school_name));
        
        if (empty($name)) {
            return response()->json([
                'suggestions' => [],
                'exists' => false
            ]);
        }

        $suggestions = [];
        $counter = 0;

        while (count($suggestions) < 5) {
            $candidate = $counter === 0 ? $name : $name . $counter;

            if (!Tenant::where('subdomain', $candidate)->exists()) {
                $suggestions[] = $candidate;
            }

            $counter++;
        }

        $exists = Tenant::where('subdomain', $name)->exists();

        return response()->json([
            'suggestions' => $suggestions,
            'exists' => $exists
        ]);
    }

    // Registration start here
    public function register(Request $request)
    {
        Log::info('=== REGISTRATION START ===', [
            'school_name' => $request->school_name,
            'email' => $request->email,
            'subdomain' => $request->subdomain,
            'phone' => $request->phone
        ]);

        try {
            $request->validate([
                'school_name' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,NULL,id,tenant_id,NULL',
                'password' => 'required|string|min:8',
                'subdomain' => 'required|string|unique:tenants,subdomain',
                'location'    => 'required|string|max:500',
                'phone' => 'required|string|regex:/^[0-9]{11}$/',
            ], [
                'phone.required' => 'Phone number is required.',
                'phone.regex' => 'Phone number must be exactly 11 digits (e.g., 08012345678).',
            ]);

            Log::info('Validation passed');

            // Create tenant
            $tenant = Tenant::create([
                'name' => $request->school_name,
                'subdomain' => $request->subdomain,
                'location'  => $request->location,
                'phone'     => $request->phone, 
                'plan' => 'free',
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addDays(30),
            ]);

            Log::info('Tenant created', ['tenant_id' => $tenant->id, 'subdomain' => $tenant->subdomain]);

            if (!$tenant) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to create tenant. Please try again.');
            }

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'tenant_id' => $tenant->id,
                'role' => 'super_admin',
            ]);

            Log::info('User created', ['user_id' => $user->id, 'email' => $user->email]);

            if (!$user) {
                // Rollback tenant creation if user fails
                $tenant->delete();
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to create user account. Please try again.');
            }

            // ✅ Send email notification using Brevo API (same pattern as DirectRegistrationController)
            $this->sendNewSchoolNotificationEmail($tenant, $user);

            // ✅ Clear any existing session
            session()->flush();
            
            // ✅ Redirect to tenant login page with success message
            $loginUrl = "http://{$tenant->subdomain}.coredesk.com.ng/login";
            
            Log::info('Registration completed successfully', ['login_url' => $loginUrl]);
            
            return redirect()->to($loginUrl)
                ->with('success', 'School created successfully! Please login with your credentials.');

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error during registration', [
                'error' => $e->getMessage(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'We could not complete your registration. Please select a subdomain of your choice below, and try again.');
                
        } catch (\Exception $e) {
            Log::error('General error during registration', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'We could not complete your registration. Please try again.');
        }
    }

    /**
     * Send email notification to admin using Brevo API
     */
    private function sendNewSchoolNotificationEmail($tenant, $user)
    {
        Log::info("📧 Sending new school notification email for {$tenant->subdomain}");

        try {
            $adminEmail = 'nnamdigodwill1960@gmail.com';
            $ownerDashboardUrl = 'http://coredesk.com.ng/owner/dashboard';

            // Get logo as base64 (optional - remove if you don't have logo)
            $logoPath = public_path('images/download.jpg');
            $logoSrc = '';
            
            if (file_exists($logoPath)) {
                $mimeType = mime_content_type($logoPath);
                $logoData = base64_encode(file_get_contents($logoPath));
                $logoSrc = 'data:'.$mimeType.';base64,'.$logoData;
            }

            $emailContent = view('emails.new-tenant-registration', [
                'tenant' => $tenant,
                'user' => $user,
                'logo_url' => $logoSrc,
                'adminUrl' => $ownerDashboardUrl,
            ])->render();

            $response = Http::withHeaders([
                'api-key' => config('services.brevo.key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'name' => 'CoreDesk System',
                    'email' => 'nnamdigodwill1960@gmail.com',
                ],
                'to' => [['email' => $adminEmail]],
                'subject' => 'New School Registration - ' . $tenant->name,
                'htmlContent' => $emailContent,
                'headers' => [
                    'X-Mailer' => 'CoreDesk/1.0'
                ]
            ]);

            if ($response->successful()) {
                Log::info("✅ Brevo email sent for new school registration", [
                    'response' => $response->json(),
                    'subdomain' => $tenant->subdomain
                ]);
            } else {
                Log::error("❌ Brevo API error for new school registration", [
                    'status' => $response->status(),
                    'response' => $response->json(),
                ]);
                
                $this->sendFallbackNotificationEmail($tenant, $user);
            }
        } catch (\Exception $e) {
            Log::error("❌ Exception sending new school registration email via Brevo API", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'subdomain' => $tenant->subdomain
            ]);
            
            $this->sendFallbackNotificationEmail($tenant, $user);
        }
    }

    /**
     * Send fallback text email if HTML email fails
     */
    private function sendFallbackNotificationEmail($tenant, $user)
    {
        try {
            $simpleContent = "New School Registration\n\n" .
                "A new school has registered on CoreDesk:\n\n" .
                "School Name: {$tenant->name}\n" .
                "Subdomain: {$tenant->subdomain}.coredesk.local\n" .
                "Location: {$tenant->location}\n" .
                "Phone: {$tenant->phone}\n" .
                "Plan: {$tenant->plan}\n" .
                "Expires: {$tenant->expires_at}\n\n" .
                "Administrator:\n" .
                "Name: {$user->name}\n" .
                "Email: {$user->email}\n\n" .
                "View in Owner Dashboard: http://coredesk.com.ng/owner/dashboard\n\n" .
                "CoreDesk System";

            $response = Http::withHeaders([
                'api-key' => config('services.brevo.key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'name' => 'CoreDesk System',
                    'email' => 'nnamdigodwill1960@gmail.com',
                ],
                'to' => [['email' => 'nnamdigodwill1960@gmail.com']],
                'subject' => 'New School Registration - ' . $tenant->name,
                'textContent' => $simpleContent,
            ]);

            Log::info("🔄 Sent fallback text email for new school registration");
        } catch (\Exception $e) {
            Log::error("🔴 Fallback notification email failed", ['error' => $e->getMessage()]);
        }
    }
}