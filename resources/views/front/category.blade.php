@extends('layouts.front')

@section('title', $category->name . ' - Zenis')

@section('content')
<div class="container" style="padding: 4rem 0;">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $category->name }}</h1>
        <p style="color: var(--text);">Browse all products in {{ $category->name }}</p>
    </div>

    <div class="product-grid">
        @forelse($products as $product)
        <div class="product-card">
            <div class="product-img">
                @if($product->hero_image)
                    <img src="{{ $product->hero_image }}" alt="{{ $product->title }}">
                @else
                    <span>No Image</span>
                @endif
            </div>
            <div class="product-info">
                <div class="product-category">{{ $category->name }}</div>
                <h3 class="product-title">
                    <a href="{{ route('pages.show', $product->slug) }}">{{ $product->title }}</a>
                </h3>
                <div class="flex justify-between items-center">
                    <span class="product-price">$250.00</span>
                    <span class="product-rating">★★★★★</span>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align:center; padding: 2rem;">
            No products found in this category.
        </div>
        @endforelse
    </div>
</div>

<style>
    /* Re-using Product Grid Styles from Home */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
    }
    .product-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s;
    }
    .product-card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        border-color: transparent;
    }
    .product-img {
        height: 250px;
        background: #f9f9f9;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .product-img img {
        max-width: 80%;
        max-height: 80%;
    }
    .product-info {
        padding: 1.5rem;
    }
    .product-category {
        font-size: 0.85rem;
        color: var(--text);
        margin-bottom: 0.5rem;
    }
    .product-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }
    .product-price {
        color: var(--primary);
        font-weight: 700;
        font-size: 1.1rem;
    }
    .product-rating {
        color: #ffc107;
        font-size: 0.9rem;
    }
</style>
@endsection
