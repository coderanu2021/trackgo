<?php

namespace App\Http\Controllers;

use App\Models\ProductPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageBuilderController extends Controller
{
    // Frontend View
    public function show($slug)
    {
        $page = ProductPage::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('front.project', compact('page'));
    }

    // Admin: List
    public function index()
    {
        $projects = ProductPage::latest()->get();
        return view('admin.builder.index', compact('projects'));
    }

    // Admin: Create
    public function create()
    {
        return view('admin.builder.create');
    }

    // Admin: Store
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:product_pages',
            'hero_image' => 'nullable|url',
            'blocks' => 'required|json',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        ProductPage::create([
            'title' => $request->title,
            'slug' => $slug,
            'hero_image' => $request->hero_image,
            'content' => json_decode($request->blocks, true),
            'is_published' => true,
        ]);

        return redirect()->route('admin.builder.index')->with('success', 'Page created successfully!');
    }

    // Admin: Edit
    public function edit($id)
    {
        $page = ProductPage::findOrFail($id);
        return view('admin.builder.edit', compact('page'));
    }

    // Admin: Update
    public function update(Request $request, $id)
    {
        $page = ProductPage::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:product_pages,slug,' . $id,
            'hero_image' => 'nullable|url',
            'blocks' => 'required|json',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        $page->update([
            'title' => $request->title,
            'slug' => $slug,
            'hero_image' => $request->hero_image,
            'content' => json_decode($request->blocks, true),
        ]);

        return redirect()->route('admin.builder.index')->with('success', 'Page updated successfully!');
    }

    // Admin: Delete
    public function destroy($id)
    {
        $page = ProductPage::findOrFail($id);
        $page->delete();
        return redirect()->route('admin.builder.index')->with('success', 'Page deleted successfully!');
    }

    // Admin: Upload Image
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        if ($request->file('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            return response()->json(['url' => asset('storage/' . $path)]);
        }

        return response()->json(['error' => 'Upload failed'], 400);
    }
}
