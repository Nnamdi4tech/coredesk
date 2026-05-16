<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExpireTenants extends Command
{
    protected $signature = 'tenants:expire';
    protected $description = 'Check for expiring subscriptions and deactivate expired tenants';

    public function handle()
    {
        $this->info('Checking for expiring subscriptions...');
        
        // 1. Check for tenants expiring in 3 days (send warning)
        $this->checkExpiringSoon();
        
        // 2. Deactivate expired tenants and send notifications
        $this->deactivateExpiredTenants();
        
        $this->info('Process completed successfully.');
    }
    
    private function checkExpiringSoon()
    {
        $threeDaysFromNow = Carbon::now()->addDays(3)->startOfDay();
        $endOfThreeDays = Carbon::now()->addDays(3)->endOfDay();
        
        $expiringTenants = Tenant::where('plan', '!=', 'free')
            ->whereNotNull('expires_at')
            ->whereBetween('expires_at', [$threeDaysFromNow, $endOfThreeDays])
            ->get();
        
        $this->info('Found ' . $expiringTenants->count() . ' tenants expiring in 3 days');
        
        foreach ($expiringTenants as $tenant) {
            $this->sendExpiringWarning($tenant);
        }
    }
    
    private function deactivateExpiredTenants()
    {
        $expiredTenants = Tenant::where('plan', '!=', 'free')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', Carbon::now())
            ->get();
        
        $this->info('Found ' . $expiredTenants->count() . ' expired tenants');
        
        foreach ($expiredTenants as $tenant) {
            // Deactivate the tenant
            $tenant->is_active = false;
            $tenant->save();
            
            // Send expiration notification
            $this->sendExpiredNotification($tenant);
        }
    }
    
    private function sendExpiringWarning($tenant)
    {
        // Get super_admin for this tenant
        $superAdmin = User::where('tenant_id', $tenant->id)
            ->where('role', 'super_admin')
            ->first();
        
        if (!$superAdmin) {
            Log::warning('No super_admin found for tenant', ['tenant_id' => $tenant->id]);
            return;
        }
        
        $expiresAt = Carbon::parse($tenant->expires_at);
        $daysLeft = Carbon::now()->diffInDays($expiresAt);
        
        // Send to super_admin
        $adminEmailContent = view('emails.subscription-expiring-warning', [
            'adminName' => $superAdmin->name,
            'schoolName' => $tenant->name,
            'expiresAt' => $expiresAt,
            'daysLeft' => $daysLeft,
            'plan' => $tenant->plan,
        ])->render();
        
        $this->sendBrevoEmail(
            $superAdmin->email,
            $superAdmin->name,
            "⚠️ Your subscription for {$tenant->name} expires in {$daysLeft} days",
            $adminEmailContent
        );
        
        // Send to owner
        $ownerEmailContent = view('emails.subscription-expiring-owner-warning', [
            'schoolName' => $tenant->name,
            'subdomain' => $tenant->subdomain,
            'adminName' => $superAdmin->name,
            'adminEmail' => $superAdmin->email,
            'plan' => $tenant->plan,
            'expiresAt' => $expiresAt,
            'daysLeft' => $daysLeft,
            'ownerDashboardUrl' => 'http://coredesk.com.ng/owner/dashboard',
            'extendUrl' => "http://coredesk.com.ng/owner/tenant/{$tenant->id}/extend"
        ])->render();
        
        $this->sendBrevoEmail(
            'nnamdigodwill1960@gmail.com',
            'CoreDesk Owner',
            "🚨 URGENT: {$tenant->name}'s subscription expires in {$daysLeft} days",
            $ownerEmailContent
        );
        
        Log::info('Expiring warning sent', [
            'tenant' => $tenant->subdomain,
            'days_left' => $daysLeft
        ]);
    }
    
    private function sendExpiredNotification($tenant)
    {
        // Get super_admin for this tenant
        $superAdmin = User::where('tenant_id', $tenant->id)
            ->where('role', 'super_admin')
            ->first();
        
        if ($superAdmin) {
            $expiresAt = Carbon::parse($tenant->expires_at);
            
            $adminEmailContent = view('emails.subscription-expired', [
                'adminName' => $superAdmin->name,
                'schoolName' => $tenant->name,
                'expiresAt' => $expiresAt,
                'plan' => $tenant->plan,
            ])->render();
            
            $this->sendBrevoEmail(
                $superAdmin->email,
                $superAdmin->name,
                "❌ Your subscription for {$tenant->name} has expired",
                $adminEmailContent
            );
        }
        
        // Send to owner
        $ownerEmailContent = view('emails.subscription-expired-owner', [
            'schoolName' => $tenant->name,
            'subdomain' => $tenant->subdomain,
            'adminName' => $superAdmin ? $superAdmin->name : 'Unknown',
            'adminEmail' => $superAdmin ? $superAdmin->email : 'Unknown',
            'plan' => $tenant->plan,
            'expiresAt' => Carbon::parse($tenant->expires_at),
            'ownerDashboardUrl' => 'http://coredesk.com.ng/owner/dashboard'
        ])->render();
        
        $this->sendBrevoEmail(
            'nnamdigodwill1960@gmail.com',
            'CoreDesk Owner',
            "❌ {$tenant->name}'s subscription has expired - Account Deactivated",
            $ownerEmailContent
        );
        
        Log::info('Expired notification sent', [
            'tenant' => $tenant->subdomain,
            'deactivated' => true
        ]);
    }
    
    private function sendBrevoEmail($toEmail, $toName, $subject, $htmlContent)
    {
        try {
            $response = Http::withHeaders([
                'api-key' => config('services.brevo.key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'name' => 'CoreDesk System',
                    'email' => env('MAIL_FROM_ADDRESS', 'nnamdigodwill1960@gmail.com'),
                ],
                'to' => [['email' => $toEmail, 'name' => $toName]],
                'subject' => $subject,
                'htmlContent' => $htmlContent,
            ]);
            
            if (!$response->successful()) {
                Log::error('Brevo API error', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
            }
            
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Exception sending Brevo email', ['error' => $e->getMessage()]);
            return false;
        }
    }
}