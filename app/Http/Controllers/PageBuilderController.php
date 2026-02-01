<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageBuilderController extends Controller
{
    // Frontend: Show general page (About, Contact, etc.)
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('front.page', compact('page'));
    }

    // Frontend: Show page by route name (for about, contact, etc.)
    public function showBySlug(Request $request)
    {
        $routeName = $request->route()->getName();
        $slug = $routeName; // Use route name as slug (about, contact, etc.)
        
        $page = Page::where('slug', $slug)->where('is_active', true)->first();
        
        if (!$page) {
            // If no dynamic page exists, fall back to static view
            return view('front.' . $slug);
        }
        
        return view('front.page', compact('page'));
    }

    // Admin: List all general pages
    public function index()
    {
        $pages = Page::where('is_enquiry', false)->latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    // Admin: Create general page form
    public function create()
    {
        return view('admin.pages.create');
    }

    // Admin: Store new general page
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages',
            'hero_image' => 'nullable|url',
            'blocks' => 'required|json',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        Page::create([
            'title' => $request->title,
            'slug' => $slug,
            'thumbnail' => $request->hero_image,
            'content' => json_decode($request->blocks, true),
            'is_active' => true,
            'is_enquiry' => false,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully!');
    }

    // Admin: Edit general page form
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    // Admin: Update general page
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $id,
            'hero_image' => 'nullable|url',
            'blocks' => 'required|json',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        $page->update([
            'title' => $request->title,
            'slug' => $slug,
            'thumbnail' => $request->hero_image,
            'content' => json_decode($request->blocks, true),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully!');
    }

    // Admin: Delete general page
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully!');
    }

    // Admin: Upload image for page builder
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
