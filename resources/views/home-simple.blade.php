<!DOCTYPE html>
<html>
<head>
    <title>Simple Home Test</title>
    <style>
        .product-card { border: 1px solid #ccc; margin: 10px; padding: 15px; display: inline-block; width: 300px; }
        .product-title { font-weight: bold; color: #333; }
        .product-price { color: #f37021; font-size: 18px; }
    </style>
</head>
<body>
    <h1>Simple Home Page Test</h1>
    
    <h2>Latest Products Section</h2>
    <p>Products found: {{ $products->count() }}</p>
    
    <div style="display: flex; flex-wrap: wrap;">
        @forelse($products->take(8) as $product)
            <div class="product-card">
                <div class="product-title">{{ $product->title }}</div>
                <div class="product-price">₹{{ formatIndianPrice($product->price, 2) }}</div>
                <p>Category: {{ $product->category->name ?? 'General' }}</p>
                <p>Stock: {{ $product->stock }}</p>
                @if($product->thumbnail)
                    <img src="{{ $product->thumbnail }}" alt="{{ $product->title }}" style="width: 100px; height: 100px; object-fit: cover;">
                @endif
            </div>
        @empty
            <p style="color: red;">No products found!</p>
        @endforelse
    </div>
    
    <h2>Categories</h2>
    <p>Categories found: {{ $categories->count() }}</p>
    
    <h2>Blogs</h2>
    <p>Blogs found: {{ $blogs->count() }}</p>
</body>
</html>