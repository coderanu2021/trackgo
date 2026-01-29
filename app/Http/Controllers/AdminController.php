<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => \App\Models\User::count(),
            'orders' => \App\Models\Order::count(),
            'revenue' => \App\Models\Order::where('status', 'completed')->sum('total_amount'),
            'products' => \App\Models\Page::count(), // E-commerce products
            'pages' => \App\Models\Page::count(), // General pages
            'categories' => \App\Models\Category::count(),
            'blogs' => \App\Models\Blog::count(),
            'reviews' => \App\Models\Review::count(),
        ];

        $recent_orders = \App\Models\Order::latest()->take(5)->get();
        $recent_blogs = \App\Models\Blog::latest()->take(5)->get();
        $recent_products = \App\Models\Page::latest()->take(5)->get(); // E-commerce products
        $pages = \App\Models\Page::latest()->take(5)->get(); // Pages for the dashboard

        return view('admin.dashboard', compact('stats', 'recent_orders', 'recent_blogs', 'recent_products', 'pages'));
    }
}
