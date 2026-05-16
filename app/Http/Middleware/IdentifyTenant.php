<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next)
    {
        // ✅ Bypass tenant check for owner routes
        if ($request->is('owner/*') || $request->is('owner')) {
            return $next($request);
        }

        
        $host = $request->getHost();

        // Skip main domain
        if (
            $host === '127.0.0.1' ||
            $host === 'localhost' ||
            $host === 'coredesk.local' ||
            $host === 'coredesk.com.ng' ||
            $host === 'www.coredesk.com.ng'
        ) {
            return $next($request);
        }

        $parts = explode('.', $host);

        // Expect: subdomain.coredesk.local = 3 parts
        if (count($parts) >= 2) {
            $subdomain = $parts[0];

            $tenant = Tenant::where('subdomain', $subdomain)->first();

            if (!$tenant) {
                abort(404, 'School not found.');
            }

            // ✅ Check if tenant is active
            // if (!$tenant->is_active) {
            //     $port = $request->getPort();
            //     $baseUrl = $port ? "http://{$host}:{$port}" : "http://{$host}";
            //     Auth::logout();
            //     return redirect()->to("{$baseUrl}/login")->with('error', 'Your school account is inactive. Please contact support.');
            // }

            // Bind tenant globally
            app()->instance('tenant', $tenant);

            // 🔐 Security: ensure logged-in user belongs to THIS tenant
            if (Auth::check()) {
                if (Auth::user()->tenant_id !== $tenant->id) {
                    Auth::logout();
                    $port = $request->getPort();
                    $baseUrl = $port ? "http://{$host}:{$port}" : "http://{$host}";
                    return redirect()->to("{$baseUrl}/login")->with('error', 'Unauthorized access.');
                }
            }
        }

        return $next($request);
    }
}