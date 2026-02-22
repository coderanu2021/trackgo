<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    // Frontend: All Categories page
    public function index()
    {
        // Get only root categories (parent_id = null)
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
        
        // Count products for each category (including products with this category as additional)
        foreach ($categories as $category) {
            $category->product_pages_count = \App\Models\ProductPage::where('is_published', true)
                ->where(function($query) use ($category) {
                    $query->where('category_id', $category->id)
                          ->orWhereHas('categories', function($subQuery) use ($category) {
                              $subQuery->where('categories.id', $category->id);
                          });
                })
                ->count();
        }
        
        return view('front.categories', compact('categories'));
    }

    // Frontend: Single Category page with products
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->with(['children' => function($query) {
                $query->where('is_active', true);
            }])
            ->firstOrFail();
        
        // Get products for this category and its children
        $categoryIds = [$category->id];
        if ($category->children->count() > 0) {
            $categoryIds = array_merge($categoryIds, $category->children->pluck('id')->toArray());
        }
        
        $products = \App\Models\ProductPage::where('is_published', true)
            ->whereIn('category_id', $categoryIds)
            ->with('category')
            ->latest()
            ->paginate(12);
        
        return view('front.category', compact('category', 'products'));
    }
}
