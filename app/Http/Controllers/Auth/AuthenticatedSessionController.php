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
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // ✅ Add this - explicitly save the session
    $request->session()->put('auth.user_id', auth()->id());

        $user = auth()->user();
        
        // Get the current host with port
        $host = $request->getHost();
        $port = $request->getPort();
        $baseUrl = $port ? "http://{$host}:{$port}" : "http://{$host}";
        
        $parts = explode('.', $host);
        $isMainDomain = ($host === 'coredesk.local' || $host === 'localhost' || $host === '127.0.0.1' || $host === 'coredesk.com.ng' || $host === 'www.coredesk.com.ng');
        
        \Log::info('Login redirect', [
            'host' => $host,
            'port' => $port,
            'baseUrl' => $baseUrl,
            'isMainDomain' => $isMainDomain,
            'role' => $user->role
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
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    // Redirect to subdomain login, not main domain
    $host = $request->getHost();
    $port = $request->getPort();
    $baseUrl = $port ? "http://{$host}:{$port}" : "http://{$host}";

    return redirect("{$baseUrl}/login");
}


}