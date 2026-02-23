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
                // Check both single category and multiple categories
                $query->where(function($q) use ($category) {
                    $q->where('category_id', $category->id)
                      ->orWhereHas('categories', function($subQ) use ($category) {
                          $subQ->where('categories.id', $category->id);
                      });
                });
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
        
        $products = $query->with(['category', 'categories'])->latest()->paginate(12);
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
        $pages = ProductPage::with(['category', 'categories'])->latest()->get();
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
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:product_pages',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'blocks' => 'required|json',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        $product = ProductPage::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'stock' => $request->stock ?? 0,
            'hero_image' => $request->hero_image,
            'thumbnail' => $request->thumbnail,
            'gallery' => $request->gallery ? json_decode($request->gallery, true) : [],
            'content' => json_decode($request->blocks, true),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'is_published' => true,
            'is_enquiry' => $request->boolean('is_enquiry'),
        ]);

        // Sync multiple categories
        if ($request->filled('categories')) {
            $product->categories()->sync($request->categories);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    // Admin: Edit product form
    public function edit($id)
    {
        $page = ProductPage::with('categories')->findOrFail($id);
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('page', 'categories'));
    }

    // Admin: Update product
    public function update(Request $request, $id)
    {
        $page = ProductPage::findOrFail($id);

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:product_pages,slug,' . $id,
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'blocks' => 'required|json',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        $page->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'stock' => $request->stock ?? 0,
            'hero_image' => $request->hero_image,
            'thumbnail' => $request->thumbnail,
            'gallery' => $request->gallery ? json_decode($request->gallery, true) : [],
            'content' => json_decode($request->blocks, true),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'is_enquiry' => $request->boolean('is_enquiry'),
        ]);

        // Sync multiple categories
        if ($request->filled('categories')) {
            $page->categories()->sync($request->categories);
        } else {
            $page->categories()->detach();
        }

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