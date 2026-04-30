<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View; 
use App\View\Composers\TenantComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('local')) {
            URL::forceRootUrl(config('app.url'));
        }
        
        // ✅ Move this OUTSIDE the if statement
        // Register tenant view composer for all views
        View::composer('*', TenantComposer::class);
    }
}