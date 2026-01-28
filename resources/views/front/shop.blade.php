@extends('layouts.front')

@section('title', 'Shop Premium Products - ' . ($settings['site_name'] ?? 'TrackGo'))

@push('styles')
<style>
    .shop-container { 
        padding: 2rem 0 4rem; 
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        min-height: 100vh;
    }
    
    /* Hero Section */
    .shop-hero {
        text-align: center;
        padding: 3rem 0 4rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        margin-bottom: 3rem;
        border-radius: 0 0 50px 50px;
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
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 1rem;
        position: relative;
        z-index: 2;
    }
    .shop-hero p {
        font-size: 1.2rem;
        opacity: 0.9;
        position: relative;
        z-index: 2;
    }
    
    /* Layout */
    .shop-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 3rem;
        align-items: start;
    }

    @media (max-width: 992px) {
        .shop-layout { grid-template-columns: 1fr; }
        .filter-sidebar { position: static; margin-bottom: 2rem; }
        .shop-hero h1 { font-size: 2.5rem; }
    }

    /* Sidebar Filters */
    .filter-sidebar {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        position: sticky;
        top: 120px;
    }

    .filter-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .filter-title i {
        color: var(--primary);
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
        color: #64748b;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .filter-link:hover { 
        background: #f8fafc; 
        color: var(--primary);
        border-color: #e2e8f0;
        transform: translateX(5px);
    }
    .filter-link.active { 
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(243, 112, 33, 0.3);
    }

    /* Toolbar */
    .shop-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem 2rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
    }

    .results-info {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .results-info i {
        color: var(--primary);
    }

    /* Product Grid */
    .product-grid-shop {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    @media (max-width: 640px) { 
        .product-grid-shop { 
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        } 
    }

    /* Enhanced Product Cards */
    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        group: product;
    }
    .product-card:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        border-color: var(--primary);
    }

    .product-img-wrapper {
        position: relative;
        aspect-ratio: 1/1;
        overflow: hidden;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .product-card:hover .product-image { transform: scale(1.08); }

    .product-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 800;
        z-index: 2;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .product-overlay {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 3;
    }
    .product-card:hover .product-overlay { 
        opacity: 1;
        transform: translateX(0);
    }

    .btn-icon {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1a1a1a;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        text-decoration: none;
        border: 1px solid rgba(255,255,255,0.2);
    }
    .btn-icon:hover { 
        background: var(--primary); 
        color: white; 
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(243, 112, 33, 0.4);
    }

    .product-info-minimal { 
        padding: 1.5rem; 
        position: relative;
    }
    .product-cat-label { 
        font-size: 0.75rem; 
        color: var(--primary); 
        text-transform: uppercase; 
        font-weight: 800; 
        letter-spacing: 0.05em; 
        margin-bottom: 0.5rem;
        background: rgba(243, 112, 33, 0.1);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        display: inline-block;
    }
    .product-title-minimal { 
        font-size: 1.1rem; 
        font-weight: 800; 
        color: #1a1a1a; 
        margin-bottom: 1rem; 
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .product-title-minimal a { 
        text-decoration: none; 
        color: inherit;
        transition: color 0.3s ease;
    }
    .product-title-minimal a:hover {
        color: var(--primary);
    }

    .product-price-minimal { 
        display: flex; 
        align-items: baseline; 
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    .price-current { 
        font-size: 1.4rem; 
        font-weight: 900; 
        color: var(--primary);
    }
    .price-old { 
        font-size: 1rem; 
        color: #94a3b8; 
        text-decoration: line-through;
    }

    .product-actions-inline {
        display: flex;
        gap: 0.75rem;
    }
    .btn-cart-inline, .btn-buy-inline {
        flex: 1;
        justify-content: center;
        padding: 0.75rem;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    .btn-cart-inline {
        background: #f8fafc;
        color: #1a1a1a;
        border: 1px solid #e2e8f0;
    }
    .btn-cart-inline:hover {
        background: #1a1a1a;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(26, 26, 26, 0.2);
    }
    .btn-buy-inline {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
    }
    .btn-buy-inline:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(243, 112, 33, 0.4);
    }

    /* Form Styling */
    .filter-form input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    .filter-form input:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(243, 112, 33, 0.1);
    }

    .filter-form button {
        width: 100%;
        padding: 0.75rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .filter-form button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(243, 112, 33, 0.4);
    }

    /* Mobile Filter */
    .btn-filter-mobile {
        display: none;
        background: white;
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 700;
        color: #1a1a1a;
        gap: 0.5rem;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-filter-mobile:hover {
        background: #f8fafc;
        border-color: var(--primary);
        color: var(--primary);
    }

    @media (max-width: 992px) {
        .btn-filter-mobile { display: flex !important; }
        .filter-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 320px;
            height: 100vh;
            z-index: 1000;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 0;
            overflow-y: auto;
            box-shadow: 0 0 50px rgba(0,0,0,0.3);
        }
        .filter-sidebar.active { left: 0; }
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

    /* Loading States */
    .load-more-status {
        text-align: center;
        padding: 3rem 0;
        display: none;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #f1f5f9;
        border-top: 3px solid var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin { 
        0% { transform: rotate(0deg); } 
        100% { transform: rotate(360deg); } 
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #64748b;
    }
    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1.5rem;
    }
    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="filter-overlay" id="filter-overlay" onclick="toggleFilters()"></div>

<section class="shop-container">
    <!-- Hero Section -->
    <div class="shop-hero">
        <div class="container">
            <h1>Explore Our Shop</h1>
            <p>Discover curated premium products for your next big project</p>
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
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min $">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max $">
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
                        <a href="{{ route('shop') }}" style="display: inline-block; margin-top: 1.5rem; padding: 0.75rem 2rem; background: var(--primary); color: white; text-decoration: none; border-radius: 12px; font-weight: 700;">View All Products</a>
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
