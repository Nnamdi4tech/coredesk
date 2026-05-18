<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     * SOLUTION 2: Clear session if already authenticated
     */
    public function create(Request $request): View
    {
        // If already logged in, logout first to prevent redirect loop
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * SOLUTION 4: Verify tenant matches
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();
        
        // Get the current host
        $host = $request->getHost();
        $port = $request->getPort();
        $baseUrl = $port ? "http://{$host}:{$port}" : "http://{$host}";
        
        $parts = explode('.', $host);
        $currentSubdomain = $parts[0];
        $isMainDomain = ($host === 'coredesk.local' || $host === 'localhost' || $host === '127.0.0.1' || $host === 'coredesk.com.ng' || $host === 'www.coredesk.com.ng');
        
        // SOLUTION 4: Verify user belongs to this tenant/subdomain
        if (!$isMainDomain && $user->role !== 'super_admin') {
            // Check if user's school matches the subdomain
            $userTenant = $user->tenant_id ?? $user->subdomain ?? null;
            
            if ($userTenant && $userTenant !== $currentSubdomain) {
                // User doesn't belong here - logout and show error
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->to("{$baseUrl}/login")
                    ->with('error', 'Invalid credentials for this school. Please login with correct school credentials.');
            }
        }
        
        \Log::info('Login redirect', [
            'host' => $host,
            'port' => $port,
            'baseUrl' => $baseUrl,
            'isMainDomain' => $isMainDomain,
            'role' => $user->role,
            'subdomain' => $currentSubdomain ?? 'main'
        ]);

        // If on main domain, redirect to owner dashboard
        if ($isMainDomain) {
            return redirect()->to("{$baseUrl}/owner/dashboard");
        }
        
        // Otherwise, on tenant subdomain
        if ($user->role === 'super_admin') {
            return redirect()->to("{$baseUrl}/admin/dashboard");
        }

        if ($user->role === 'teacher') {
            return redirect()->to("{$baseUrl}/teacher/dashboard");
        }

        if ($user->role === 'accountant') {
            return redirect()->to("{$baseUrl}/finance/dashboard");
        }

        return redirect()->to("{$baseUrl}/dashboard");
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Get host before logout
        $host = $request->getHost();
        $port = $request->getPort();
        $baseUrl = $port ? "http://{$host}:{$port}" : "http://{$host}";
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the same subdomain login page
        return redirect("{$baseUrl}/login");
    }
}