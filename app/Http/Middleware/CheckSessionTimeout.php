<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        // Skip for owner routes
        if ($request->is('owner/*') || $request->routeIs('owner.*')) {
            return $next($request);
        }

        // Skip for login/register routes
        if ($request->is('login') || $request->is('register') || $request->is('*/login')) {
            return $next($request);
        }

        // Only check timeout for authenticated users
        if (Auth::check()) {
            $lastActivity = session('last_activity');
            $timeout = config('session.lifetime') * 60;

            if ($lastActivity && (time() - $lastActivity) > $timeout) {
                Auth::logout();
                session()->flush();

                // ✅ Redirect to current host login, not named route
                $host    = $request->getHost();
                $port    = $request->getPort();
                $baseUrl = $port ? "http://{$host}:{$port}" : "http://{$host}";

                return redirect("{$baseUrl}/login")
                    ->with('error', 'Your session has expired due to inactivity.');
            }

            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}