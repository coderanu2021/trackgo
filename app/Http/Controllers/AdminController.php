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
            'products' => \App\Models\ProductPage::count(),
            'categories' => \App\Models\Category::count(),
            'blogs' => \App\Models\Blog::count(),
            'subscribers' => \App\Models\Newsletter::count(),
        ];

        $recent_orders = \App\Models\Order::latest()->take(5)->get();
        $recent_blogs = \App\Models\Blog::latest()->take(5)->get();
        $projects = \App\Models\ProductPage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'recent_blogs', 'projects'));
    }
}
