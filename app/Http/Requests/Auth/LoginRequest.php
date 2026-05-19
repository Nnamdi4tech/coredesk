<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // ✅ Get tenant_id from the current subdomain
        $tenantId = null;
        if (app()->bound('tenant')) {
            $tenantId = app('tenant')->id;
        }

        $credentials = $this->only('email', 'password');

        // ✅ Add tenant_id to credentials so login is scoped to this school only
        if ($tenantId) {
            $credentials['tenant_id'] = $tenantId;
        }

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // ✅ **CRITICAL: Call the tenant validation here**
        $user = Auth::user();
        if (!$this->ensureUserBelongsToTenant($user)) {
            Auth::logout();
            RateLimiter::hit($this->throttleKey());
            
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials for this school. Please login with correct school credentials.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }

    /**
     * Ensure user belongs to the current tenant/subdomain
     */
    protected function ensureUserBelongsToTenant($user): bool
{
    $host = request()->getHost();
    $isMainDomain = ($host === 'coredesk.com.ng' || $host === 'www.coredesk.com.ng');
    
    // Skip for main domain
    if ($isMainDomain) {
        return true;
    }

    // Allow super_admin through
    if ($user->role === 'super_admin') {
        return true;
    }

    // Get the current tenant from the app container
    if (!app()->bound('tenant')) {
        return true;
    }

    $tenant = app('tenant');

    // Compare user's tenant_id with the current tenant's id
    if ($user->tenant_id !== $tenant->id) {
        return false;
    }

    return true;
}



    
}
