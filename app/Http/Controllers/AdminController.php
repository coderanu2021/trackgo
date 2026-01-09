<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $projects = \App\Models\ProductPage::latest()->take(5)->get();
        return view('admin.dashboard', compact('projects'));
    }
}
