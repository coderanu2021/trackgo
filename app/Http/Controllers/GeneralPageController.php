<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GeneralPageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.products.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages',
            'blocks' => 'required|json',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        Page::create([
            'title' => $request->title,
            'slug' => $slug,
            'price' => $request->price ?? 0,
            'discount' => $request->discount ?? 0,
            'stock' => $request->stock ?? 0,
            'thumbnail' => $request->thumbnail,
            'gallery' => $request->gallery ? json_decode($request->gallery, true) : [],
            'content' => json_decode($request->blocks, true),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'is_active' => true,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product detail created successfully!');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.products.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $id,
            'blocks' => 'required|json',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        $page->update([
            'title' => $request->title,
            'slug' => $slug,
            'price' => $request->price ?? 0,
            'discount' => $request->discount ?? 0,
            'stock' => $request->stock ?? 0,
            'thumbnail' => $request->thumbnail,
            'gallery' => $request->gallery ? json_decode($request->gallery, true) : [],
            'content' => json_decode($request->blocks, true),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product detail updated successfully!');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product detail deleted successfully!');
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('front.page', compact('page'));
    }
}
