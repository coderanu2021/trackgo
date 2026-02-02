<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('front.cart', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = \App\Models\ProductPage::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "title" => $product->title,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->hero_image
            ];
        }

        session()->put('cart', $cart);

        // If it's an AJAX request, return JSON response
        if ($request->ajax()) {
            $cartCount = array_sum(array_column($cart, 'quantity'));
            $cartTotal = array_sum(array_map(function($item) {
                return $item['price'] * $item['quantity'];
            }, $cart));

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => $cartCount,
                'cart_total' => formatIndianPrice($cartTotal, 2),
                'product' => [
                    'id' => $id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'quantity' => $cart[$id]['quantity']
                ]
            ]);
        }

        // Regular redirect for non-AJAX requests
        if ($request->has('redirect') && $request->redirect == 'checkout') {
            return redirect()->route('checkout.index')->with('success', 'Product added to cart successfully!');
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
}
