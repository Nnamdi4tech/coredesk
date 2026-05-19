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
    
    // ✅ FIXED: Verify user belongs to this tenant using tenant ID, not subdomain string
    if (!$isMainDomain && $user->role !== 'super_admin') {
        // Get the current tenant from middleware
        $currentTenant = app('tenant');
        
        if ($currentTenant && $user->tenant_id !== $currentTenant->id) {
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
        'subdomain' => $currentSubdomain ?? 'main',
        'user_tenant_id' => $user->tenant_id,
        'current_tenant_id' => app('tenant')->id ?? null
    ]);

    // If on main domain, redirect to owner dashboard
    if ($isMainDomain) {
        return redirect('/owner/dashboard');
    }
    
    // ✅ FIXED: Use relative paths (works with subdomain)
    if ($user->role === 'super_admin') {
        return redirect('/admin/dashboard');
    }

    if ($user->role === 'teacher') {
        return redirect('/teacher/dashboard');
    }

    if ($user->role === 'accountant') {
        return redirect('/finance/dashboard');
    }

    return redirect('/dashboard');
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
{
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // ✅ Simple redirect - works with subdomain
    return redirect('/login');
}
} 