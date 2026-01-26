<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $request->image,
            'icon' => $request->icon,
            'is_active' => $request->has('is_active'),
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $request->image,
            'icon' => $request->icon,
            'is_active' => $request->has('is_active'),
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }

    // Frontend Method
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $products = $category->productPages()->where('is_published', true)->get();
        return view('front.category', compact('category', 'products'));
    }
}
