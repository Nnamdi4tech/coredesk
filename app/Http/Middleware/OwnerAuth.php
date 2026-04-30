<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OwnerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'owner') {
            return redirect()->route('owner.login');
        }

        return $next($request);
    }
}