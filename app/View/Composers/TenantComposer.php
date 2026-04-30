<?php

namespace App\View\Composers;

use Illuminate\View\View;

class TenantComposer
{
    public function compose(View $view)
    {
        // ✅ Safe check - tenant may not be bound on non-tenant routes
        if (!app()->bound('tenant')) {
            return;
        }

        // Share tenant with all views
        $tenant = app('tenant');
        $view->with('tenant', $tenant);

        // Share subdomain with all views
        $subdomain = request()->route('subdomain');
        if (!$subdomain) {
            $host = request()->getHost();
            $parts = explode('.', $host);
            $subdomain = $parts[0] ?? null;
        }
        $view->with('subdomain', $subdomain);
    }
}