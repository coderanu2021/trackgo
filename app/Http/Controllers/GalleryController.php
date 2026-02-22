<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // Frontend: Gallery page
    public function index(Request $request)
    {
        $query = Gallery::where('is_active', true)->with('category');
        
        // Filter by category if provided
        if ($request->filled('category')) {
            $category = GalleryCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->where('gallery_category_id', $category->id);
            }
        }
        
        $galleries = $query->orderBy('order')->latest()->paginate(12);
        $categories = GalleryCategory::where('is_active', true)->get();
        
        return view('front.gallery', compact('galleries', 'categories'));
    }

    // Admin: List all gallery items
    public function adminIndex()
    {
        $galleries = Gallery::with('category')->latest()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    // Admin: Create gallery form
    public function create()
    {
        $categories = GalleryCategory::where('is_active', true)->get();
        return view('admin.gallery.create', compact('categories'));
    }

    // Admin: Store new gallery item
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'order' => 'nullable|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/gallery'), $imageName);
            $imagePath = 'uploads/gallery/' . $imageName;
        }

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'gallery_category_id' => $request->gallery_category_id,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item created successfully!');
    }

    // Admin: Edit gallery form
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $categories = GalleryCategory::where('is_active', true)->get();
        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    // Admin: Update gallery item
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'order' => 'nullable|integer',
        ]);

        $imagePath = $gallery->image;
        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image && file_exists(public_path($gallery->image))) {
                unlink(public_path($gallery->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/gallery'), $imageName);
            $imagePath = 'uploads/gallery/' . $imageName;
        }

        $gallery->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'gallery_category_id' => $request->gallery_category_id,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated successfully!');
    }

    // Admin: Delete gallery item
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        
        // Delete image file
        if ($gallery->image && file_exists(public_path($gallery->image))) {
            unlink(public_path($gallery->image));
        }
        
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item deleted successfully!');
    }
}
