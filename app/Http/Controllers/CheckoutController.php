<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty!');
        }
        return view('front.checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'customer_phone' => 'required',
            'shipping_address' => 'required',
        ]);

        $cart = session()->get('cart');
        $total = 0;
        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'status' => 'pending'
        ]);

        foreach($cart as $id => $details) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_page_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Order placed successfully! Order ID: ' . $order->id);
    }
}
