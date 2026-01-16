@extends('layouts.front')

@section('title', 'Shop Premium Products - ' . ($settings['site_name'] ?? 'TrackGo'))

@push('styles')
<style>
    .shop-container { padding: 4rem 0; background: #fcfdfe; }
    
    /* Layout */
    .shop-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 3rem;
        align-items: start;
    }

    @media (max-width: 992px) {
        .shop-layout { grid-template-columns: 1fr; }
        .filter-sidebar { position: static; margin-bottom: 2rem; }
    }

    /* Sidebar Filters */
    .filter-sidebar {
        background: white;
        padding: 2.5rem;
        border-radius: 24px;
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-sm);
        position: sticky;
        top: 100px;
    }

    .filter-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--secondary);
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-soft);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filter-group { margin-bottom: 2.5rem; }
    .filter-group:last-child { margin-bottom: 0; }
    
    .filter-list { list-style: none; padding: 0; margin: 0; }
    .filter-list li { margin-bottom: 0.75rem; }
    
    .filter-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.5rem 0;
        transition: var(--transition);
    }
    
    .filter-link:hover, .filter-link.active { color: var(--primary); }
    .filter-link span { font-size: 0.8rem; background: var(--bg-light); padding: 0.2rem 0.6rem; border-radius: 50px; }

    /* Product Grid */
    .product-grid-shop {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    @media (max-width: 1200px) { .product-grid-shop { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { .product-grid-shop { grid-template-columns: 1fr; } }

    /* Product Card Enhancements */
    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid var(--border-soft);
        transition: var(--transition);
    }
    .product-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-lg); border-color: var(--primary-soft); }

    .product-img-wrapper {
        position: relative;
        aspect-ratio: 1/1;
        overflow: hidden;
        background: #f8fafc;
    }
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .product-card:hover .product-image { transform: scale(1.1); }

    .product-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: var(--primary);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 800;
        z-index: 2;
    }

    .product-overlay {
        position: absolute;
        bottom: -60px;
        left: 0;
        width: 100%;
        padding: 1.5rem;
        display: flex;
        justify-content: center;
        gap: 1rem;
        background: linear-gradient(to top, rgba(0,0,0,0.1), transparent);
        transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 3;
    }
    .product-card:hover .product-overlay { bottom: 0; }

    .btn-icon {
        width: 45px;
        height: 45px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--secondary);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: var(--transition);
        text-decoration: none;
    }
    .btn-icon:hover { background: var(--primary); color: white; transform: scale(1.1); }

    .product-info-minimal { padding: 1.5rem; }
    .product-cat-label { font-size: 0.75rem; color: var(--text-light); text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
    .product-title-minimal { font-size: 1.1rem; font-weight: 800; color: var(--secondary); margin-bottom: 0.75rem; line-height: 1.3; }
    .product-title-minimal a { text-decoration: none; color: inherit; }
    .product-price-minimal { display: flex; align-items: baseline; gap: 0.75rem; }
    .price-current { font-size: 1.25rem; font-weight: 900; color: var(--primary); }
    .price-old { font-size: 0.9rem; color: var(--text-light); text-decoration: line-through; }

    /* Loading Area */
    .load-more-status {
        text-align: center;
        padding: 4rem 0;
        display: none;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid var(--border-soft);
        border-top: 4px solid var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* Mobile Filter Drawer */
    @media (max-width: 992px) {
        .btn-filter-mobile { display: flex !important; }
        .filter-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 300px;
            height: 100vh;
            z-index: 1000;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 0;
            overflow-y: auto;
        }
        .filter-sidebar.active { left: 0; }
        .mobile-filter-header { display: flex !important; }
    }

</style>
@endpush

@section('content')
<section class="shop-container">
    <div class="container text-center" style="margin-bottom: 4rem;">
        <h1 style="font-size: 3.5rem; font-weight: 900; color: var(--secondary); letter-spacing: -0.04em;">Explore Our Shop</h1>
        <p style="color: var(--text-muted); font-size: 1.2rem;">Discover curated premium products for your next big project.</p>
    </div>

    <div class="container">
        <div class="shop-layout">
            <!-- Sidebar -->
            <aside class="filter-sidebar" id="filter-sidebar">
                <div class="mobile-filter-header" style="display: none; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h3 style="margin: 0; font-size: 1.25rem;">Filters</h3>
                    <button type="button" onclick="toggleFilters()" style="background: none; border: none; font-size: 1.5rem; color: var(--secondary);"><i class="fas fa-times"></i></button>
                </div>

                <div class="filter-group">
                    <h3 class="filter-title">Categories</h3>
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
                    <h3 class="filter-title">Price Range</h3>
                    <form action="{{ route('shop') }}" method="GET">
                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-soft); border-radius: 12px; font-size: 0.85rem;">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-soft); border-radius: 12px; font-size: 0.85rem;">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; border-radius: 12px; font-size: 0.9rem;">Filter Price</button>
                    </form>
                </div>

                <div class="filter-group">
                    <h3 class="filter-title">Search</h3>
                    <form action="{{ route('shop') }}" method="GET">
                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        <div style="position: relative;">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 1rem; border: 1px solid var(--border-soft); border-radius: 12px; font-size: 0.85rem;">
                            <i class="fas fa-search" style="position: absolute; right: 1rem; top: 1rem; color: var(--text-light);"></i>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="shop-main">
                <div class="shop-toolbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <button type="button" class="btn btn-filter-mobile" onclick="toggleFilters()" style="display: none; background: white; border: 1px solid var(--border-soft); padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 700; color: var(--secondary); gap: 0.5rem; align-items: center;">
                        <i class="fas fa-filter"></i> Filters
                    </button>
                    <div style="color: var(--text-muted); font-size: 0.9rem; font-weight: 600;">
                        Showing <span id="current-count">{{ $products->count() }}</span> of {{ $products->total() }} results
                    </div>
                </div>

                <div id="product-grid" class="product-grid-shop">
                    @include('front.partials.product_list')
                </div>

                <div id="load-more-status" class="load-more-status">
                    <div class="spinner"></div>
                </div>

                <div id="no-more-products" class="load-more-status">
                    <p style="color: var(--text-muted); font-weight: 600;">You've reached the end of our shop. Check back later!</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    let page = 1;
    let loading = false;
    let hasMore = true;

    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 800) {
            if (!loading && hasMore) {
                loadMoreProducts();
            }
        }
    });

    function toggleFilters() {
        $('#filter-sidebar').toggleClass('active');
        if($('#filter-sidebar').hasClass('active')) {
            $('body').css('overflow', 'hidden');
        } else {
            $('body').css('overflow', 'auto');
        }
    }

    function loadMoreProducts() {
        if (loading) return; 
        loading = true;
        page++;
        $('#load-more-status').show();

        const params = new URLSearchParams(window.location.search);
        params.set('page', page);

        $.ajax({
            url: "{{ route('shop') }}?" + params.toString(),
            type: "GET",
            success: function(data) {
                if (data.trim() == "") {
                    hasMore = false;
                    $('#load-more-status').hide();
                    $('#no-more-products').show();
                    return;
                }
                $('#load-more-status').hide();
                $('#product-grid').append(data);
                
                // Update showing count
                let count = $('.product-card').length;
                $('#current-count').text(count);
                
                loading = false;
            },
            error: function() {
                loading = false;
                $('#load-more-status').hide();
            }
        });
    }
</script>
@endpush
