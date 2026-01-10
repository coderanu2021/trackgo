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
        return view('front.home', compact('products', 'categories'));
    }
}
