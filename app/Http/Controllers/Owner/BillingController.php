<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class BillingController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('owner.billing.index', compact('plans'));
    }

    public function store(Request $request)
    {
        Plan::create($request->all());
        return back()->with('success', 'Plan created');
    }

    public function update(Request $request, $id)
{
    $plan = Plan::findOrFail($id);
    $plan->update($request->all());

    return redirect()->route('owner.billing.index')->with('success', 'Plan updated');
}

public function edit($id)
{
    $plan = Plan::findOrFail($id);
    return view('owner.billing.editplan', compact('plan'));
}

    public function delete($id)
    {
        Plan::findOrFail($id)->delete();
        return back()->with('success', 'Plan deleted');
    }
}