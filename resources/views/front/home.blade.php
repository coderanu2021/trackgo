@extends('layouts.front')

@section('title', 'Zenis - Home')

@section('content')
<style>
    /* Hero */
    .hero-section {
        background: var(--white);
        padding: 2rem 0;
    }
    .hero-grid {
        display: grid;
        grid-template-columns: 3fr 1fr;
        gap: 2rem;
    }
    .hero-slider {
        background: #f6f9fc;
        border-radius: 8px;
        padding: 4rem;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    .hero-content h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
        line-height: 1.2;
    }
    .hero-content p {
        font-size: 1.25rem;
        color: var(--text);
        margin-bottom: 2rem;
    }
    .btn-shop {
        background: var(--primary);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 4px;
        font-weight: 600;
        display: inline-block;
    }

    /* Features */
    .features-section {
        padding: 3rem 0;
    }
    .features-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }
    .feature-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        transition: box-shadow 0.3s;
    }
    .feature-item:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .feature-icon {
        font-size: 2rem;
        color: var(--primary);
    }

    /* Section Headers */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-title::before {
        content: '';
        display: block;
        width: 4px;
        height: 24px;
        background: var(--primary);
        border-radius: 2px;
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 4rem;
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

<!-- Hero -->
<section class="hero-section container">
    <style>
        .hero-grid {
            display: grid;
            grid-template-columns: 250px 1fr 250px; /* Sidebar | Slider | Banners */
            gap: 2rem;
        }
        /* Mobile responsive fix */
        @media (max-width: 1024px) {
            .hero-grid { grid-template-columns: 1fr; }
            .category-sidebar { display: none; }
        }
        .category-sidebar {
            background: white;
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
        }
        .cat-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border);
            transition: 0.3s;
        }
        .cat-link:hover { padding-left: 1.5rem; color: var(--primary); }
    </style>

    <div class="hero-grid">
        <!-- Sidebar -->
        <div class="category-sidebar">
            <div style="background:var(--secondary); color:white; padding:1rem; font-weight:600;">Browse Categories</div>
            @if(isset($categories_global))
                @foreach($categories_global as $cat)
                <a href="#" class="cat-link">
                    @if($cat->icon) <i class="{{ $cat->icon }}"></i> @endif
                    {{ $cat->name }}
                </a>
                @endforeach
            @endif
        </div>

        <!-- Slider -->
        <div class="hero-slider">
            <div class="hero-content">
                <p class="text-primary" style="font-weight:600;">Trending Item</p>
                <h1>Women's Latest<br>Fashion Sale</h1>
                <p>Starting at $20.00</p>
                <a href="#" class="btn-shop">Shop Now</a>
            </div>
            <div style="flex:1; text-align:right;">
                <!-- Placeholder for Hero Image -->
                <div style="width:300px; height:300px; background:#ddd; display:inline-block; border-radius:50%;"></div>
            </div>
        </div>

        <!-- Banners -->
        <div style="display:flex; flex-direction:column; gap:2rem;">
            <div style="flex:1; background:#edf2f7; border-radius:8px; padding:2rem; display:flex; flex-direction:column; justify-content:center;">
                <h3>Summer Offer</h3>
                <p class="text-primary">New Arraival</p>
            </div>
            <div style="flex:1; background:#2b3445; color:white; border-radius:8px; padding:2rem; display:flex; flex-direction:column; justify-content:center;">
                <h3>AMLED Sound</h3>
                <p>Headphone</p>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features-section container">
    <div class="features-grid">
        <div class="feature-item">
            <div class="feature-icon">🚚</div>
            <div>
                <div style="font-weight:600;">Free Shipping</div>
                <div style="font-size:0.85rem; color:var(--text);">From all orders over $100</div>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">💳</div>
            <div>
                <div style="font-weight:600;">Secure Payment</div>
                <div style="font-size:0.85rem; color:var(--text);">100% secure payment</div>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">🎧</div>
            <div>
                <div style="font-weight:600;">24/7 Support</div>
                <div style="font-size:0.85rem; color:var(--text);">Ready support</div>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">🎁</div>
            <div>
                <div style="font-weight:600;">Gift Service</div>
                <div style="font-size:0.85rem; color:var(--text);">Support gift box</div>
            </div>
        </div>
    </div>
</section>

<!-- Projects / Products -->
<section class="container" style="padding: 4rem 0;">
    <div class="section-header">
        <h2 class="section-title">New Arrivals</h2>
        <a href="#" class="text-primary">View All</a>
    </div>

    <div class="product-grid">
        <!-- Re-using existing 'projects' data as products for now -->
        @forelse($projects as $project)
        <div class="product-card">
            <div class="product-img">
                @if($project->hero_image)
                    <img src="{{ $project->hero_image }}" alt="{{ $project->title }}">
                @else
                    <span>No Image</span>
                @endif
            </div>
            <div class="product-info">
                <div class="product-category">Project</div>
                <h3 class="product-title">
                    <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                </h3>
                <div class="flex justify-between items-center">
                    <span class="product-price">$250.00</span>
                    <span class="product-rating">★★★★★</span>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align:center;">No items found.</div>
        @endforelse
    </div>
</section>
@endsection
