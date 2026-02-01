<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = session()->get('wishlist', []);
        return view('front.wishlist', compact('wishlist'));
    }

    public function add(Request $request, $id)
    {
        $product = \App\Models\ProductPage::findOrFail($id);
        $wishlist = session()->get('wishlist', []);

        if(!isset($wishlist[$id])) {
            $wishlist[$id] = [
                "title" => $product->title,
                "price" => $product->price,
                "image" => $product->hero_image, // Changed from thumbnail to hero_image
                "slug" => $product->slug
            ];
        }

        session()->put('wishlist', $wishlist);

        // If it's an AJAX request, return JSON response
        if ($request->ajax()) {
            $wishlistCount = count($wishlist);

            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist successfully!',
                'wishlist_count' => $wishlistCount,
                'product' => [
                    'id' => $id,
                    'title' => $product->title,
                    'price' => $product->price
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Product added to wishlist successfully!');
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $wishlist = session()->get('wishlist');
            if(isset($wishlist[$request->id])) {
                unset($wishlist[$request->id]);
                session()->put('wishlist', $wishlist);
            }

            // If it's an AJAX request, return JSON response
            if ($request->ajax()) {
                $wishlistCount = count($wishlist);

                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from wishlist successfully!',
                    'wishlist_count' => $wishlistCount
                ]);
            }

            session()->flash('success', 'Product removed from wishlist successfully!');
        }

        return redirect()->back();
    }
}