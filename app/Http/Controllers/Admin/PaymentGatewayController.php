<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $gateways = PaymentGateway::orderBy('sort_order')->get();
        return view('admin.payment-gateways.index', compact('gateways'));
    }

    public function show(PaymentGateway $paymentGateway)
    {
        return view('admin.payment-gateways.show', compact('paymentGateway'));
    }

    public function edit(PaymentGateway $paymentGateway)
    {
        return view('admin.payment-gateways.edit', compact('paymentGateway'));
    }

    public function update(Request $request, PaymentGateway $paymentGateway)
    {
        $request->validate([
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_test_mode' => 'boolean',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'sort_order' => 'required|integer|min:0'
        ]);

        $paymentGateway->update([
            'display_name' => $request->display_name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'is_test_mode' => $request->has('is_test_mode'),
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Payment gateway updated successfully.');
    }

    public function toggleStatus(PaymentGateway $paymentGateway)
    {
        $paymentGateway->update([
            'is_active' => !$paymentGateway->is_active
        ]);

        $status = $paymentGateway->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Payment gateway {$status} successfully.");
    }
}
