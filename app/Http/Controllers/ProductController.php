<?php

namespace App\Http\Controllers;

use App\Models\ProductPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Frontend: Shop page
    public function shop(Request $request)
    {
        $query = ProductPage::where('is_published', true);
        
        // Filter by category if provided
        if ($request->filled('category')) {
            $category = \App\Models\Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        // Filter by search term if provided
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('meta_description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('meta_keywords', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        $products = $query->with('category')->latest()->paginate(12);
        $categories = \App\Models\Category::where('is_active', true)->get();
        
        return view('front.shop', compact('products', 'categories'));
    }

    // Frontend: Single product page
    public function show($slug)
    {
        $page = ProductPage::where('slug', $slug)->where('is_published', true)->with(['reviews' => function($q) {
            $q->where('is_approved', true)->latest();
        }])->firstOrFail();

        $hasPurchased = false;
        if (auth()->check()) {
            $hasPurchased = \App\Models\OrderItem::where('product_page_id', $page->id)
                ->whereHas('order', function($q) {
                    $q->where('user_id', auth()->id());
                })->exists();
        }

        return view('front.product', compact('page', 'hasPurchased'));
    }

    // Admin: List all products
    public function index()
    {
        $pages = ProductPage::with('category')->latest()->get();
        return view('admin.products.index', compact('pages'));
    }

    // Admin: Create product form
    public function create()
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    // Admin: Store new product
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:product_pages',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'blocks' => 'required|json',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        ProductPage::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'price' => $request->price ?? 0,
            'stock' => $request->stock ?? 0,
            'hero_image' => $request->hero_image,
            'content' => json_decode($request->blocks, true),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'is_published' => true,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    // Admin: Edit product form
    public function edit($id)
    {
        $page = ProductPage::findOrFail($id);
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('page', 'categories'));
    }

    // Admin: Update product
    public function update(Request $request, $id)
    {
        $page = ProductPage::findOrFail($id);

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:product_pages,slug,' . $id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'blocks' => 'required|json',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        $page->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'price' => $request->price ?? 0,
            'stock' => $request->stock ?? 0,
            'hero_image' => $request->hero_image,
            'content' => json_decode($request->blocks, true),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    // Admin: Delete product
    public function destroy($id)
    {
        $page = ProductPage::findOrFail($id);
        $page->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}