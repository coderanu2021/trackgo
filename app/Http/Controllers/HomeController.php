<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Page::where('is_active', true)->latest()->take(8)->get();
        $categories = \App\Models\Category::where('is_active', true)->whereNull('parent_id')->with('children')->get();
        $blogs = \App\Models\Blog::where('is_published', true)->latest()->take(3)->get();
        $hero_slides = \App\Models\Banner::where('is_active', true)->orderBy('order')->get();
        $brands = \App\Models\Brand::where('status', true)->get();
        
        // Debug logging
        \Log::info('HomeController Debug', [
            'products_count' => $products->count(),
            'products_class' => get_class($products),
            'first_product' => $products->first() ? $products->first()->title : 'No products'
        ]);
        
        return view('front.home', compact('products', 'categories', 'blogs', 'hero_slides', 'brands'));
    }

    public function pricing()
    {
        $plans = \App\Models\Plan::where('is_active', true)->get();
        return view('front.pricing', compact('plans'));
    }

    public function faqs()
    {
        $faqs = \App\Models\Faq::where('is_active', true)->orderBy('sort_order')->get();
        return view('front.faqs', compact('faqs'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
            'product_id' => 'nullable|exists:pages,id'
        ]);

        // Logic to send email or save enquiry could go here.
        // For now, we'll just simulate success.

        return back()->with('success', 'Thank you for your enquiry! We will get back to you shortly.');
    }
}
