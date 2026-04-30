<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;

class BillingController extends Controller
{
    public function index($subdomain)
    {
        $tenant = app('tenant');
        $plans = Plan::all();
        $freePlan = Plan::where('name', 'free')->first();

        return view('admin.billing.index', compact('tenant', 'plans', 'freePlan', 'subdomain'));
    }

  public function billing()
{
    $tenant = Tenant::find(session('tenant_id')); // or get from auth
    $plans = Plan::all();
    $freePlan = Plan::where('name', 'free')->first();
    
    return view('admin.billing.index', compact('tenant', 'plans', 'freePlan'));
}








}




