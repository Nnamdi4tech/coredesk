<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;

class OwnerController extends Controller
{

    public function registerForm()
    {
        return view('owner.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,NULL,id,tenant_id,NULL',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'role'      => 'owner',
            'tenant_id' => null,
        ]);

        return redirect()->route('owner.login')
            ->with('success', 'Owner account created. Please login.');
    }


    public function loginForm()
    {
        return view('owner.login');
    }


    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    // Invalidate old session completely
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    if (auth()->attempt($credentials, $request->filled('remember'))) {
        
        // Regenerate session multiple times to ensure it sticks
        $request->session()->regenerate(true); // true = destroy old session
        $request->session()->regenerateToken();
        
        if (auth()->user()->role !== 'owner') {
            auth()->logout();
            return back()->with('error', 'Unauthorized. Only owners can access this portal.');
        }

        // Manually set session cookie
        $sessionId = session()->getId();
        cookie()->queue(cookie('laravel_session', $sessionId, 120, '/', null, false, true, false, 'lax'));
        
        // Save session explicitly
        session()->save();

        // Add a small delay to ensure cookie is set
        sleep(1);

        return redirect()->route('owner.dashboard')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    return back()->with('error', 'Invalid credentials. Please check your email and password.');
}




    public function dashboard()
 {
    $tenants = Tenant::latest()->get();
    $owners = User::where('role', 'super_admin')
                  ->with('tenant')   // ✅ eager load tenant
                  ->get();

    return view('owner.dashboard', compact('tenants', 'owners'));
  } 

    public function logout(Request $request)
  {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('owner.login');
  }

    public function updatePlan(Request $request, $id)
  {
    $tenant = Tenant::findOrFail($id);

    $plan = $request->plan;

    $tenant->plan = $plan;

    if ($plan === 'free') {
        $tenant->starts_at = null;
        $tenant->expires_at = null;
    } else {
        $tenant->starts_at = Carbon::now();
        $tenant->expires_at = Carbon::now()->addDays(30);
    }

    $tenant->save();

    return back()->with('success', 'Plan updated');
  }


public function toggleStatus($id)
{
    $tenant = Tenant::findOrFail($id);

    $tenant->is_active = !$tenant->is_active;
    $tenant->save();

    return back()->with('success', 'Status updated');
}

public function extend($id)
{
    $tenant = Tenant::findOrFail($id);

    if ($tenant->expires_at) {
        $tenant->expires_at = Carbon::parse($tenant->expires_at)->addDays(30);
    } else {
        $tenant->starts_at = Carbon::now();
        $tenant->expires_at = Carbon::now()->addDays(30);
    }

    $tenant->save();

    return back()->with('success', 'Subscription extended');
}

















}