@extends('layouts.front')

@section('title', 'All Categories - ' . ($settings['site_name'] ?? 'TrackGo'))

@push('styles')
<style>
    .categories-hero {
        text-align: center;
        padding: 4rem 0 5rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }
    .categories-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .categories-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .categories-container {
        padding: 2rem 0 4rem;
        background: #f8f9fa;
        min-height: 100vh;
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    .category-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .category-image-wrapper {
        position: relative;
        aspect-ratio: 16/9;
        overflow: hidden;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
    }

    .category-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .category-card:hover .category-image {
        transform: scale(1.05);
    }

    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
        display: flex;
        align-items: flex-end;
        padding: 1.5rem;
    }

    .category-name-overlay {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .category-info {
        padding: 1.5rem;
    }

    .category-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .category-count {
        font-size: 0.9rem;
        color: var(--primary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .category-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(243, 112, 33, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .category-icon img {
        width: 35px;
        height: 35px;
        object-fit: contain;
    }

    .view-products-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: var(--primary);
        color: white;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 1rem;
        transition: all 0.3s ease;
    }

    .view-products-btn:hover {
        background: var(--primary-hover);
        transform: translateX(5px);
    }

    @media (max-width: 768px) {
        .categories-hero h1 {
            font-size: 2rem;
        }
        .categories-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }
    }

    @media (max-width: 480px) {
        .categories-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="categories-hero">
    <div class="container">
        <h1>All Categories</h1>
        <p>Browse our complete collection of product categories</p>
    </div>
</div>

<div class="categories-container">
    <div class="container">
        @if($categories->count() > 0)
            <div class="categories-grid">
                @foreach($categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}" class="category-card">
                        <div class="category-image-wrapper">
                            @if($category->banner)
                                <img src="{{ asset($category->banner) }}" alt="{{ $category->name }}" class="category-image">
                            @elseif($category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="category-image">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-folder" style="font-size: 4rem; color: white; opacity: 0.5;"></i>
                                </div>
                            @endif
                            <div class="category-overlay">
                                <h3 class="category-name-overlay">{{ $category->name }}</h3>
                            </div>
                        </div>
                        <div class="category-info">
                            @if($category->image && !$category->banner)
                                <div class="category-icon">
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                                </div>
                            @endif
                            <h3 class="category-name">{{ $category->name }}</h3>
                            @if($category->summary)
                                <p style="font-size: 0.9rem; color: #6c757d; margin-bottom: 1rem; line-height: 1.5;">
                                    {{ Str::limit($category->summary, 100) }}
                                </p>
                            @endif
                            <div class="category-count">
                                <i class="fas fa-box"></i>
                                {{ $category->product_pages_count }} {{ Str::plural('Product', $category->product_pages_count) }}
                            </div>
                            <span class="view-products-btn">
                                View Products
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 4rem 2rem; color: #6c757d;">
                <i class="fas fa-folder-open" style="font-size: 4rem; color: #dee2e6; margin-bottom: 1.5rem;"></i>
                <h3 style="font-size: 1.5rem; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem;">No Categories Found</h3>
                <p>Categories will appear here once they are added.</p>
            </div>
        @endif
    </div>
</div>
@endsection
