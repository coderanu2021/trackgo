<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Payment\PaymentManager;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $paymentManager;

    public function __construct(PaymentManager $paymentManager)
    {
        $this->paymentManager = $paymentManager;
    }

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
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);

        // Create order items
        foreach($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_page_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        // Clear cart
        session()->forget('cart');

        // Redirect to payment methods selection
        return redirect()->route('payment.methods', $order);
    }

    public function orderSuccess(Order $order)
    {
        return view('front.order-success', compact('order'));
    }
}
