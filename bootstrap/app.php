<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->validateCsrfTokens(except: [
            '*/logout',
        ]);

        // ✅ Only add CheckSessionTimeout to specific route groups, not globally
        // $middleware->appendToGroup('web', [
        //     \App\Http\Middleware\CheckSessionTimeout::class,
        // ]);

        $middleware->alias([
            'tenant'           => \App\Http\Middleware\IdentifyTenant::class,
            'owner'            => \App\Http\Middleware\OwnerAuth::class,
            'student.auth'     => \App\Http\Middleware\StudentAuth::class,
            'tenant.status'    => \App\Http\Middleware\CheckTenantStatus::class,
            'session.timeout'  => \App\Http\Middleware\CheckSessionTimeout::class, // Now applied manually
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();