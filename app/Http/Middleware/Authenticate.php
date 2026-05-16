<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            $host = $request->getHost();
            $port = $request->getPort();
            
            $baseUrl = $port ? "http://{$host}:{$port}" : "http://{$host}";
            
            // Check if on a subdomain (not main domain)
            $isSubdomain = ($host !== 'coredesk.local' && $host !== 'localhost' && $host !== '127.0.0.1' && $host !== 'coredesk.com.ng' && $host !== 'www.coredesk.com.ng');
            
            if ($isSubdomain) {
                return "{$baseUrl}/login";
            }
            
            return route('home');
        }
        
        return null;
    }
}