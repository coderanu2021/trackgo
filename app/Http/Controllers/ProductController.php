<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function shop(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        
        $query = Page::where('is_active', true);

        // Filters
        if ($request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->latest()->paginate(12);

        if ($request->ajax()) {
            return view('front.partials.product_list', compact('products'))->render();
        }

        return view('front.shop', compact('products', 'categories'));
    }
}
