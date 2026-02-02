@extends('layouts.front')

@section('title', 'Shop Premium Products - ' . ($settings['site_name'] ?? 'TrackGo'))

@push('styles')
<style>
    .shop-container { 
        padding: 2rem 0 4rem; 
        background: #f8f9fa;
        min-height: 100vh;
    }
    
    /* Hero Section - Orange Theme */
    .shop-hero {
        text-align: center;
        padding: 4rem 0 5rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white;
        margin-bottom: 4rem;
        position: relative;
        overflow: hidden;
    }
    .shop-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    .shop-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        position: relative;
        z-index: 2;
    }
    .shop-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
        position: relative;
        z-index: 2;
        max-width: 600px;
        margin: 0 auto;
    }
    
    /* Layout - Zenis Style */
    .shop-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2rem;
        align-items: start;
    }

    @media (max-width: 992px) {
        .shop-layout { grid-template-columns: 1fr; }
        .filter-sidebar { 
            display: none; /* Hide on mobile, show via toggle */
        }
        .shop-hero h1 { font-size: 2.2rem; }
    }

    /* Sidebar Filters - Zenis Style */
    .filter-sidebar {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        height: fit-content;
        position: sticky;
        top: 2rem;
        display: block; /* Always show on desktop */
        z-index: 1; /* Lower z-index to stay behind other content */
    }
    
    @media (max-width: 992px) {
        .filter-sidebar {
            display: none; /* Hide by default on mobile */
            position: fixed;
            top: 0;
            left: -100%;
            width: 320px;
            height: 100vh;
            z-index: 1000;
            transition: 0.4s ease;
            border-radius: 0;
            overflow-y: auto;
            box-shadow: 0 0 50px rgba(0,0,0,0.3);
        }
        .filter-sidebar.active { 
            display: block;
            left: 0; 
        }
    }

    /* Main Content */
    .shop-main {
        position: relative;
        z-index: 2; /* Higher z-index than sidebar */
        background: #f8f9fa; /* Ensure background covers sidebar */
    }

    .filter-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: -1.5rem -1.5rem 1.5rem -1.5rem;
    }
    .filter-title i {
        color: white;
        font-size: 1rem;
    }

    .filter-group { margin-bottom: 2rem; }
    .filter-group:last-child { margin-bottom: 0; }
    
    .filter-list { list-style: none; padding: 0; margin: 0; }
    .filter-list li { margin-bottom: 0.5rem; }
    
    .filter-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
        color: #6c757d;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 0.75rem 1rem;
        border-radius: 6px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .filter-link:hover { 
        background: #f8f9fa; 
        color: var(--primary);
        border-color: #e9ecef;
    }
    .filter-link.active { 
        background: var(--primary);
        color: white;
        box-shadow: 0 2px 8px rgba(243, 112, 33, 0.3);
    }

    /* Toolbar - Orange Theme */
    .shop-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem 2rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(243, 112, 33, 0.2);
        border: 1px solid var(--primary);
        color: white;
    }

    .results-info {
        color: white;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .results-info i {
        color: white;
    }

    /* Product Grid - Zenis Style */
    .product-grid-shop {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    @media (max-width: 640px) { 
        .product-grid-shop { 
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        } 
    }

    /* Enhanced Product Cards - Zenis Style */
    .product-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        max-width: 100%;
    }
    .product-card:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        border-color: var(--primary);
    }

    .product-img-wrapper {
        position: relative;
        aspect-ratio: 4/3; /* Make images less square, more rectangular */
        overflow: hidden;
        background: #f8f9fa;
    }
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .product-card:hover .product-image { transform: scale(1.03); }

    .product-badge {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white;
        padding: 0.25rem 0.6rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        z-index: 2;
        text-transform: uppercase;
        box-shadow: 0 2px 8px rgba(243, 112, 33, 0.3);
    }

    .product-badge.new {
        background: linear-gradient(135deg, #27ae60 0%, #219a52 100%);
    }

    .product-overlay {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        opacity: 0;
        transform: translateX(15px);
        transition: all 0.3s ease;
        z-index: 3;
    }
    .product-card:hover .product-overlay { 
        opacity: 1;
        transform: translateX(0);
    }

    .btn-icon {
        width: 35px;
        height: 35px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2c3e50;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        text-decoration: none;
        border: 1px solid rgba(255,255,255,0.2);
        cursor: pointer;
        font-size: 0.8rem;
    }
    .btn-icon:hover { 
        background: #3498db; 
        color: white; 
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }

    .product-info-minimal { 
        padding: 1rem; 
        position: relative;
    }
    .product-cat-label { 
        font-size: 0.7rem; 
        color: var(--primary); 
        text-transform: uppercase; 
        font-weight: 600; 
        letter-spacing: 0.05em; 
        margin-bottom: 0.4rem;
        background: rgba(243, 112, 33, 0.1);
        padding: 0.2rem 0.6rem;
        border-radius: 4px;
        display: inline-block;
    }
    .product-title-minimal { 
        font-size: 1rem; 
        font-weight: 600; 
        color: #2c3e50; 
        margin-bottom: 0.5rem; 
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.6rem; /* Ensure consistent height */
    }
    .product-title-minimal a { 
        text-decoration: none; 
        color: inherit;
        transition: color 0.3s ease;
    }
    .product-title-minimal a:hover {
        color: var(--primary);
    }

    /* Star Rating */
    .product-rating {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 0.5rem;
    }
    .stars {
        display: flex;
        gap: 1px;
    }
    .star {
        color: #ffc107;
        font-size: 0.75rem;
    }
    .star.empty {
        color: #e9ecef;
    }
    .rating-count {
        font-size: 0.7rem;
        color: #6c757d;
        font-weight: 500;
    }

    .product-price-minimal { 
        display: flex; 
        align-items: baseline; 
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .price-current { 
        font-size: 1.1rem; 
        font-weight: 700; 
        color: var(--primary);
    }
    .price-old { 
        font-size: 0.9rem; 
        color: #95a5a6; 
        text-decoration: line-through;
    }



    .product-actions-inline {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        align-items: center;
    }
    
    .btn-icon-action {
        width: 40px;
        height: 40px;
        background: #f8f9fa;
        color: #6c757d;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        text-decoration: none;
    }
    .btn-icon-action:hover {
        background: #e74c3c;
        color: white;
        border-color: #e74c3c;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(231, 76, 60, 0.3);
    }
    .btn-icon-action.cart:hover {
        background: var(--primary);
        border-color: var(--primary);
        box-shadow: 0 3px 8px rgba(243, 112, 33, 0.3);
    }
    .btn-icon-action.view:hover {
        background: var(--primary);
        border-color: var(--primary);
        box-shadow: 0 3px 8px rgba(243, 112, 33, 0.3);
    }

    /* Form Styling - Zenis Style */
    .filter-form input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: white;
    }
    .filter-form input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(243, 112, 33, 0.1);
    }

    .filter-form button {
        width: 100%;
        padding: 0.75rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .filter-form button:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(243, 112, 33, 0.3);
    }

    /* Mobile Filter - Orange Theme */
    .btn-filter-mobile {
        display: none;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        border: 1px solid var(--primary);
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        color: white;
        gap: 0.5rem;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(243, 112, 33, 0.2);
    }
    .btn-filter-mobile:hover {
        background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary) 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(243, 112, 33, 0.3);
    }

    @media (max-width: 992px) {
        .btn-filter-mobile { display: flex !important; }
        .mobile-filter-header { display: flex !important; }
        .filter-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .filter-overlay.active {
            opacity: 1;
            visibility: visible;
        }
    }

    /* Loading States - Zenis Style */
    .load-more-status {
        text-align: center;
        padding: 3rem 0;
        display: none;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #e9ecef;
        border-top: 3px solid var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin { 
        0% { transform: rotate(0deg); } 
        100% { transform: rotate(360deg); } 
    }

    /* Empty State - Orange Theme */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
        background: linear-gradient(135deg, rgba(243, 112, 33, 0.05) 0%, rgba(243, 112, 33, 0.02) 100%);
        border-radius: 12px;
        border: 2px dashed rgba(243, 112, 33, 0.2);
    }
    .empty-state i {
        font-size: 4rem;
        color: var(--primary);
        margin-bottom: 1.5rem;
        opacity: 0.7;
    }
    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    /* Additional Mobile Styles */
    @media (max-width: 768px) {
        .shop-hero {
            padding: 2.5rem 0 3rem;
        }
        .shop-hero h1 {
            font-size: 1.8rem;
        }
        .shop-hero p {
            font-size: 0.95rem;
        }
        .shop-toolbar {
            padding: 1rem;
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        .results-info {
            text-align: center;
        }
        .product-grid-shop {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1rem;
        }
        .product-info-minimal {
            padding: 0.8rem;
        }
        .product-title-minimal {
            font-size: 0.95rem;
        }
        .btn-icon-action {
            width: 35px;
            height: 35px;
            font-size: 0.8rem;
        }btn-icon-action {
            width: 35px;
            height: 35px;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 480px) {
        .product-grid-shop {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 0.8rem;
        }
        .shop-container {
            padding: 1rem 0 2rem;
        }
        .container {
            padding: 0 1rem;
        }
        .shop-hero {
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .shop-hero h1 {
            font-size: 1.6rem;
        }
    }

    /* Ensure proper spacing */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="filter-overlay" id="filter-overlay" onclick="toggleFilters()"></div>

<section class="shop-container">
    <!-- Hero Section -->
    <div class="shop-hero">
        <div class="container">
            <h1>Shop</h1>
            <p>Discover our premium collection of products crafted with excellence and designed for your lifestyle</p>
        </div>
    </div>

    <div class="container">
        <div class="shop-layout">
            <!-- Sidebar -->
            <aside class="filter-sidebar" id="filter-sidebar">
                <div class="mobile-filter-header" style="display: none; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800;">Filters</h3>
                    <button type="button" onclick="toggleFilters()" style="background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer;"><i class="fas fa-times"></i></button>
                </div>

                <div class="filter-group">
                    <h3 class="filter-title">
                        <i class="fas fa-layer-group"></i>
                        Categories
                    </h3>
                    <ul class="filter-list">
                        <li>
                            <a href="{{ route('shop') }}" class="filter-link {{ !request('category') ? 'active' : '' }}">
                                All Products
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="filter-link {{ request('category') == $cat->slug ? 'active' : '' }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="filter-group">
                    <h3 class="filter-title">
                        <i class="fas fa-dollar-sign"></i>
                        Price Range
                    </h3>
                    <form action="{{ route('shop') }}" method="GET" class="filter-form">
                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        <div style="display: flex; gap: 0.75rem; margin-bottom: 1rem;">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min ₹">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max ₹">
                        </div>
                        <button type="submit">Apply Filter</button>
                    </form>
                </div>

                <div class="filter-group">
                    <h3 class="filter-title">
                        <i class="fas fa-search"></i>
                        Search Products
                    </h3>
                    <form action="{{ route('shop') }}" method="GET" class="filter-form">
                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        <div style="position: relative; margin-bottom: 1rem;">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." style="padding-right: 3rem;">
                            <i class="fas fa-search" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                        </div>
                        <button type="submit">Search Now</button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="shop-main">
                <div class="shop-toolbar">
                    <button type="button" class="btn-filter-mobile" onclick="toggleFilters()">
                        <i class="fas fa-filter"></i> Filters
                    </button>
                    <div class="results-info">
                        <i class="fas fa-box"></i>
                        Showing <span id="current-count">{{ $products->count() }}</span> of {{ $products->total() }} products
                    </div>
                </div>

                @if($products->count() > 0)
                    <div id="product-grid" class="product-grid-shop">
                        @include('front.partials.product_list')
                    </div>

                    <div id="load-more-status" class="load-more-status">
                        <div class="spinner"></div>
                        <p style="color: #64748b; font-weight: 600;">Loading more products...</p>
                    </div>

                    <div id="no-more-products" class="load-more-status">
                        <p style="color: #64748b; font-weight: 600;">🎉 You've seen all our amazing products!</p>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <h3>No Products Found</h3>
                        <p>Try adjusting your filters or search terms to find what you're looking for.</p>
                        <a href="{{ route('shop') }}" style="display: inline-block; margin-top: 1.5rem; padding: 0.75rem 2rem; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%); color: white; text-decoration: none; border-radius: 12px; font-weight: 700; box-shadow: 0 4px 12px rgba(243, 112, 33, 0.3);">View All Products</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    let page = 1;
    let loading = false;
    let hasMore = {{ $products->hasMorePages() ? 'true' : 'false' }};

    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 800) {
            if (!loading && hasMore) {
                loadMoreProducts();
            }
        }
    });

    function toggleFilters() {
        $('#filter-sidebar').toggleClass('active');
        $('#filter-overlay').toggleClass('active');
        if($('#filter-sidebar').hasClass('active')) {
            $('body').css('overflow', 'hidden');
        } else {
            $('body').css('overflow', 'auto');
        }
    }

    function loadMoreProducts() {
        if (loading || !hasMore) return; 
        loading = true;
        page++;
        $('#load-more-status').show();

        const params = new URLSearchParams(window.location.search);
        params.set('page', page);

        $.ajax({
            url: "{{ route('shop') }}?" + params.toString(),
            type: "GET",
            success: function(response) {
                $('#load-more-status').hide();
                
                if (response.trim() == "" || !response.includes('product-card')) {
                    hasMore = false;
                    $('#no-more-products').show();
                    return;
                }
                
                $('#product-grid').append(response);
                
                // Update showing count
                let count = $('.product-card').length;
                $('#current-count').text(count);
                
                loading = false;
            },
            error: function() {
                loading = false;
                $('#load-more-status').hide();
                console.error('Failed to load more products');
            }
        });
    }

    // Close filters when clicking outside on mobile
    $(document).on('click', function(e) {
        if ($(window).width() <= 992) {
            if (!$(e.target).closest('.filter-sidebar, .btn-filter-mobile').length) {
                if ($('#filter-sidebar').hasClass('active')) {
                    toggleFilters();
                }
            }
        }
    });
</script>
@endpush
