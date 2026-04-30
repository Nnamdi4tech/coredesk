<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Owner\BillingController;

/*
|--------------------------------------------------------------------------
| CoreDesk Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| Registration Page
|--------------------------------------------------------------------------
*/

Route::get('/register', function () {
    return view('auth.register');
})->name('register');


/*
|--------------------------------------------------------------------------
| Subdomain Check
|--------------------------------------------------------------------------
*/

Route::get('/check-subdomain', [TenantController::class, 'checkSubdomain']);


/*
|--------------------------------------------------------------------------
| Tenant Registration
|--------------------------------------------------------------------------
*/

Route::post('/tenant/register', [TenantController::class, 'register'])->name('tenant.register');


/*
|--------------------------------------------------------------------------
| Main Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Tenant Subdomain Routes
|--------------------------------------------------------------------------
*/

// Route::domain('{subdomain}.coredesk.local')
//     ->middleware('identify.tenant')
//     ->group(base_path('routes/tenant.php'));

// ✅middleware runs via web group
Route::domain('{subdomain}.coredesk.local')
    ->group(base_path('routes/tenant.php'));


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/


// Owner route
Route::prefix('owner')->group(function () {
    Route::get('/login', [OwnerController::class, 'loginForm'])->name('owner.login');
    Route::post('/login', [OwnerController::class, 'login'])->name('owner.login.post');
    Route::get('/register', [OwnerController::class, 'registerForm'])->name('owner.register');
    Route::post('/register', [OwnerController::class, 'register'])->name('owner.register.post');

    Route::middleware(\App\Http\Middleware\OwnerAuth::class)->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
        Route::post('/logout', [OwnerController::class, 'logout'])->name('owner.logout');

        // ✅ Add these 3 missing routes
        Route::post('/tenant/{id}/plan', [OwnerController::class, 'updatePlan'])->name('owner.tenant.plan');
        Route::post('/tenant/{id}/toggle', [OwnerController::class, 'toggleStatus'])->name('owner.tenant.toggle');
        Route::post('/tenant/{id}/extend', [OwnerController::class, 'extend'])->name('owner.tenant.extend');
        
        //Plan
       Route::get('/billing', [BillingController::class, 'index'])->name('owner.billing.index');
        Route::post('/billing/store', [BillingController::class, 'store'])->name('owner.plan.store');
        Route::post('/billing/update/{id}', [BillingController::class, 'update'])->name('owner.plan.update');
        Route::get('/billing/edit/{id}', [BillingController::class, 'edit'])->name('owner.plan.edit');
        Route::post('/billing/delete/{id}', [BillingController::class, 'delete'])->name('owner.plan.delete');
    });

});

//Test mail
//Test mail using Brevo API
Route::get('/debug-mail', function () {
    // Log Brevo API configuration
    \Log::info('Brevo API Config Debug', [
        'BREVO_API_KEY' => config('services.brevo.key') ? 'SET' : 'NOT SET',
        'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
        'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
    ]);
    
    // Test Brevo API connection
    try {
        $response = Http::withHeaders([
            'api-key' => config('services.brevo.key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => 'CoreDesk Test',
                'email' => 'nnamdigodwill1960@gmail.com',
            ],
            'to' => [['email' => 'nnamdigodwill1960@gmail.com']],
            'subject' => 'Test Email from CoreDesk',
            'htmlContent' => '<h1>Test Email</h1><p>This is a test email from CoreDesk to verify Brevo API is working.</p>',
            'textContent' => 'This is a test email from CoreDesk to verify Brevo API is working.',
        ]);
        
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Brevo API test email sent successfully! Check your inbox.',
                'response' => $response->json(),
                'config' => [
                    'api_key' => config('services.brevo.key') ? 'SET' : 'NOT SET',
                    'from_email' => env('MAIL_FROM_ADDRESS'),
                    'to_email' => 'nnamdigodwill1960@gmail.com',
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Brevo API error',
                'status' => $response->status(),
                'response' => $response->json(),
                'config' => [
                    'api_key' => config('services.brevo.key') ? 'SET' : 'NOT SET',
                    'from_email' => env('MAIL_FROM_ADDRESS'),
                ]
            ]);
        }
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'config' => [
                'api_key' => config('services.brevo.key') ? 'SET' : 'NOT SET',
                'from_email' => env('MAIL_FROM_ADDRESS'),
            ]
        ]);
    }
});


require __DIR__.'/auth.php';