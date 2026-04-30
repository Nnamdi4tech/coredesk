<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceSessionRegeneration
{
    public function handle(Request $request, Closure $next)
    {
        // If user is logging in, ensure session is regenerated properly
        if ($request->is('owner/login') && $request->isMethod('post')) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        
        return $next($request);
    }
}