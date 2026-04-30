<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User; 

class TenantController extends Controller
{
    // check if subdomain exist here or not function start here. 
    public function checkSubdomain(Request $request)
  {
    if (!$request->school_name) {
        return response()->json([
            'suggestions' => [],
            'exists' => false
        ]);
    }

    $name = strtolower(preg_replace('/[^a-z0-9]+/', '', $request->school_name));
    
    if (empty($name)) {
        return response()->json([
            'suggestions' => [],
            'exists' => false
        ]);
    }

    $suggestions = [];
    $counter = 0;

    while (count($suggestions) < 5) {
        $candidate = $counter === 0 ? $name : $name . $counter;

        if (!Tenant::where('subdomain', $candidate)->exists()) {
            $suggestions[] = $candidate;
        }

        $counter++;
    }

    $exists = Tenant::where('subdomain', $name)->exists();

    return response()->json([
        'suggestions' => $suggestions,
        'exists' => $exists
    ]);
   }


    //  Registration start here
    public function register(Request $request)
{
    try {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'subdomain' => 'required|string|unique:tenants,subdomain',
        ]);

        // Create tenant
        $tenant = Tenant::create([
            'name' => $request->school_name,
            'subdomain' => $request->subdomain,
            'plan' => 'free',
        ]);

        if (!$tenant) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create tenant. Please try again.');
        }

        // Create user
        $user = User::create([
            'name' => $request->owner_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tenant_id' => $tenant->id,
            'role' => 'super_admin', // ✅ Important for redirection
        ]);

        if (!$user) {
            // Rollback tenant creation if user fails
            $tenant->delete();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create user account. Please try again.');
        }

        // ✅ AUTO-LOGIN THE USER
        auth()->login($user);

        // ✅ REDIRECT TO TENANT SUBDOMAIN DASHBOARD
        $subdomain = $tenant->subdomain;
        
        return redirect()->to("http://{$tenant->subdomain}.coredesk.local:8000/login")
           ->with('success', "School created! You can now login.");

    } catch (\Illuminate\Database\QueryException $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'We could not complete your registration. Please select a subdomain of your choice below, and try again.');
            
    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'We could not complete your registration. Please try again.');
    }
}
//   ends here




}