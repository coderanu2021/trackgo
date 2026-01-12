<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = \App\Models\Subscription::with(['user', 'plan', 'product', 'order'])->latest()->get();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $users = \App\Models\User::all();
        $plans = \App\Models\Plan::where('is_active', true)->get();
        $products = \App\Models\ProductPage::all();
        return view('admin.subscriptions.create', compact('users', 'plans', 'products'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'customer_name' => 'required_without:user_id|nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required'
        ]);

        \App\Models\Subscription::create($request->all());
        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription created successfully.');
    }

    public function edit($id)
    {
        $subscription = \App\Models\Subscription::findOrFail($id);
        $users = \App\Models\User::all();
        $plans = \App\Models\Plan::where('is_active', true)->get();
        $products = \App\Models\ProductPage::all();
        return view('admin.subscriptions.edit', compact('subscription', 'users', 'plans', 'products'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required_without:user_id|nullable|string|max:255', // If we allow updating user_id (or if it was null)
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required'
        ]);

        $subscription = \App\Models\Subscription::findOrFail($id);
        $subscription->update($request->all());
        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    public function notify($id)
    {
        $sub = \App\Models\Subscription::findOrFail($id);
        
        $phone = $sub->customer_phone ?? $sub->order->customer_phone ?? ($sub->user->phone ?? 'N/A');
        // Note: User model might not have 'phone', adjusting fallback logic based on available data.
        // Assuming we rely on customer_phone or order->customer_phone mostly.
        
        if ($phone === 'N/A' || empty($phone)) {
            return back()->with('error', 'No phone number linked to this subscription.');
        }

        $customerName = $sub->user->name ?? $sub->customer_name ?? $sub->order->customer_name ?? 'Customer';
        $daysLeft = now()->diffInDays($sub->end_date, false);
        $message = "Hello {$customerName}, this is a manual reminder. Your subscription (ID: {$sub->id}) expires in {$daysLeft} days (" . $sub->end_date->format('Y-m-d') . "). Please renew it.";

        // Generate WhatsApp Link
        $whatsappUrl = "https://wa.me/{$phone}?text=" . urlencode($message);

        \App\Models\SubscriptionLog::create([
            'subscription_id' => $sub->id,
            'type' => 'manual',
            'message' => $message,
            'status' => 'logged', // Changed to logged since it's opening manual link
            'sent_at' => now(),
        ]);

        return back()->with('success', "Notification recorded. WhatsApp Web opening...")->with('whatsapp_url', $whatsappUrl);
    }

    public function destroy($id)
    {
        \App\Models\Subscription::findOrFail($id)->delete();
        return back()->with('success', 'Subscription deleted.');
    }
}
