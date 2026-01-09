<?php

namespace App\Http\Controllers;

use App\Models\ProductPage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $projects = ProductPage::where('is_published', true)->latest()->get();
        return view('front.home', compact('projects'));
    }
}
