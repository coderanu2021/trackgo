<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'cycle' => 'required',
        ]);

        $data = $request->all();
        $data['features'] = json_encode(explode("\n", str_replace("\r", "", $request->features)));
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        Plan::create($data);
        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        $plan->features_text = implode("\n", json_decode($plan->features) ?? []);
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'cycle' => 'required',
        ]);

        $data = $request->all();
        $data['features'] = json_encode(explode("\n", str_replace("\r", "", $request->features)));
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        $plan->update($data);
        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully.');
    }
}
