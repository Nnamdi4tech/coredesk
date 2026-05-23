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

    // ✅ FIXED LOGIN METHOD
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials, $request->filled('remember'))) {
            
            if (auth()->user()->role !== 'owner') {
                auth()->logout();
                return back()->with('error', 'Unauthorized. Only owners can access this portal.');
            }

            // ✅ Only one session regeneration needed
            $request->session()->regenerate();

            return redirect()->route('owner.dashboard');
        }

        return back()->with('error', 'Invalid credentials. Please check your email and password.');
    }

    public function dashboard()
    {
        $tenants = Tenant::latest()->get();
        $owners = User::where('role', 'super_admin')
                      ->with('tenant')
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