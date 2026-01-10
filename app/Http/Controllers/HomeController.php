<?php

namespace App\Http\Controllers;

use App\Models\ProductPage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = ProductPage::where('is_published', true)->latest()->get();
        $categories = \App\Models\Category::where('is_active', true)->get();
        $blogs = \App\Models\Blog::where('is_published', true)->latest()->take(3)->get();
        return view('front.home', compact('products', 'categories', 'blogs'));
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
}
