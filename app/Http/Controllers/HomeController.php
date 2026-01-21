<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Page::where('is_active', true)->latest()->take(8)->get();
        $categories = \App\Models\Category::where('is_active', true)->get();
        $blogs = \App\Models\Blog::where('is_published', true)->latest()->take(3)->get();
        $hero_slides = \App\Models\Banner::where('type', 'main')->orderBy('order')->get();
        $brands = \App\Models\Brand::where('status', true)->get();
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
}
