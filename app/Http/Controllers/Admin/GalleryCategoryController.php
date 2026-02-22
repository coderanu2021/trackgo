<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryCategoryController extends Controller
{
    public function index()
    {
        $categories = GalleryCategory::withCount('galleries')->orderBy('order')->get();
        return view('admin.gallery-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.gallery-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        GalleryCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Gallery category created successfully!');
    }

    public function edit($id)
    {
        $category = GalleryCategory::findOrFail($id);
        return view('admin.gallery-categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = GalleryCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Gallery category updated successfully!');
    }

    public function destroy($id)
    {
        $category = GalleryCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.gallery-categories.index')->with('success', 'Gallery category deleted successfully!');
    }
}
