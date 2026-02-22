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
            'banner' => $request->banner,
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
        $request->validate([
            'name' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:512',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'summary' => $request->summary,
            'icon' => $request->icon,
            'is_active' => $request->has('is_active'),
            'parent_id' => $request->parent_id
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/categories'), $imageName);
            $data['image'] = 'uploads/categories/' . $imageName;
            
            // Delete old image if exists
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
        }

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $bannerName = time() . '_banner_' . $banner->getClientOriginalName();
            $banner->move(public_path('uploads/categories'), $bannerName);
            $data['banner'] = 'uploads/categories/' . $bannerName;
            
            // Delete old banner if exists
            if ($category->banner && file_exists(public_path($category->banner))) {
                unlink(public_path($category->banner));
            }
        }

        $category->update($data);

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
        
        // Get products that have this category either as primary or additional category
        $products = \App\Models\ProductPage::where('is_published', true)
            ->where(function($query) use ($category) {
                $query->where('category_id', $category->id)
                      ->orWhereHas('categories', function($subQuery) use ($category) {
                          $subQuery->where('categories.id', $category->id);
                      });
            })
            ->with(['category', 'categories'])
            ->get();
            
        return view('front.category', compact('category', 'products'));
    }
}
