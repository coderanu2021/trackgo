@extends('layouts.front')

@section('title', 'Zenis - Home')

@section('content')
<style>
    /* Hero Section */
    .hero-section {
        padding: 3rem 0;
        position: relative;
    }
    .hero-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: var(--radius-lg);
        min-height: 550px;
        display: flex;
        align-items: center;
        overflow: hidden;
        position: relative;
    }
    .hero-content {
        padding: 5rem;
        z-index: 10;
        max-width: 650px;
    }
    .hero-sub {
        color: var(--primary);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 1rem;
        display: block;
    }
    .hero-title {
        color: white;
        font-size: 4rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 2rem;
        letter-spacing: -0.03em;
    }
    .hero-image {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 50%;
        object-fit: cover;
        opacity: 0.9;
        mask-image: linear-gradient(to left, black 60%, transparent 100%);
    }

    /* Features */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-top: -3rem;
        position: relative;
        z-index: 20;
    }
    .feature-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 2rem;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s;
    }
    .feature-card:hover { transform: translateY(-5px); }
    .feature-icon-box {
        width: 50px;
        height: 50px;
        background: rgba(99, 102, 241, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.25rem;
    }

    /* Product Cards */
    .section-label {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 3rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2.5rem;
    }
    .p-card {
        background: var(--white);
        border-radius: var(--radius-md);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid var(--border);
        position: relative;
    }
    .p-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: transparent;
    }
    .p-img-box {
        aspect-ratio: 4/5;
        background: var(--bg-light);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        overflow: hidden;
    }
    .p-img-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.6s;
    }
    .p-card:hover .p-img-box img { transform: scale(1.1); }
    
    .p-info { padding: 1.5rem; }
    .p-cat {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .p-name {
        font-weight: 700;
        font-size: 1.15rem;
        margin-bottom: 0.75rem;
        color: var(--secondary);
    }
    .p-price {
        font-family: 'Outfit', sans-serif;
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary);
    }
    .p-action {
        position: absolute;
        bottom: 1.5rem;
        right: 1.5rem;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s;
    }
    .p-card:hover .p-action { opacity: 1; transform: translateY(0); }
</style>

<!-- Hero -->
<section class="hero-section container">
    <div class="hero-banner">
        <div class="hero-content">
            <span class="hero-sub">Summer Collection 2026</span>
            <h1 class="hero-title">Elevate Your<br>Creative Style<span>.</span></h1>
            <p style="color: rgba(255,255,255,0.7); font-size: 1.15rem; margin-bottom: 3rem; line-height: 1.7;">
                Discover a curated collection of premium products and innovative projects designed for the modern creator.
            </p>
            <a href="#shop" class="btn btn-primary" style="padding: 1.15rem 2.5rem; font-size: 1.05rem;">
                Explore Collection <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <img src="{{ asset('brain/39b36ce9-2dd6-4117-8634-bcaf44d5170d/hero_fashion_creative_1768026224591.png') }}" class="hero-image" alt="Luxury Fashion">
    </div>
</section>

<!-- Features Bar -->
<section class="container">
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon-box"><i class="fas fa-truck-fast"></i></div>
            <div>
                <div style="font-weight: 700;">Global Express</div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">Secure worldwide shipping</div>
            </div>
        </div>
        <div class="feature-card">
            <div class="feature-icon-box"><i class="fas fa-shield-halved"></i></div>
            <div>
                <div style="font-weight: 700;">Safe Transact</div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">End-to-end encryption</div>
            </div>
        </div>
        <div class="feature-card">
            <div class="feature-icon-box"><i class="fas fa-headset"></i></div>
            <div>
                <div style="font-weight: 700;">Expert Support</div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">24/7 technical assistance</div>
            </div>
        </div>
        <div class="feature-card">
            <div class="feature-icon-box"><i class="fas fa-arrows-rotate"></i></div>
            <div>
                <div style="font-weight: 700;">Easy Returns</div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">30-day seamless process</div>
            </div>
        </div>
    </div>
</section>

<!-- Taxonomy & Shop -->
<section id="shop" class="container" style="padding: 8rem 0;">
    <div style="display: flex; gap: 4rem;">
        <!-- Left Sidebar: Categorization -->
        <aside style="width: 300px; flex-shrink: 0;">
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem;">Categories</h3>
            <div style="background: var(--bg-light); border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border);">
                @if(isset($categories))
                    @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" 
                       style="display: flex; align-items: center; justify-content: space-between; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); font-weight: 600; font-size: 0.95rem; transition: 0.3s; transition: all 0.3s ease;"
                       onmouseover="this.style.background='white'; this.style.color='var(--primary)';"
                       onmouseout="this.style.background='transparent'; this.style.color='inherit';">
                        <span style="display: flex; align-items: center; gap: 0.75rem;">
                            <i class="{{ $cat->icon ?? 'fas fa-chevron-right' }}" style="font-size: 0.85rem; width: 20px;"></i>
                            {{ $cat->name }}
                        </span>
                        <i class="fas fa-angle-right" style="font-size: 0.75rem; opacity: 0.5;"></i>
                    </a>
                    @endforeach
                @endif
            </div>
            
            <!-- Banner Ad -->
            <div style="margin-top: 3rem; background: var(--secondary); border-radius: var(--radius-md); padding: 2.5rem; color: white;">
                <h4 style="font-size: 1.25rem; margin-bottom: 1rem;">Newsletter</h4>
                <p style="font-size: 0.85rem; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">Get exclusive offers and product updates.</p>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="text" placeholder="Email" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.1); padding: 0.75rem; border-radius: 8px; color: white; width: 100%;">
                    <button class="btn btn-primary" style="padding: 0 1rem;"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </aside>

        <!-- Right Content: Products -->
        <div style="flex: 1;">
            <div class="section-label">Featured Collections</div>
            <div class="product-grid">
                @forelse($products as $product)
                <div class="p-card">
                    <div class="p-img-box">
                        <img src="{{ $product->hero_image ?? 'https://via.placeholder.com/400x500?text=Premium+Item' }}" alt="{{ $product->title }}">
                    </div>
                    <div class="p-info">
                        <div class="p-cat">{{ $product->category->name ?? 'Premium' }}</div>
                        <h3 class="p-name">{{ $product->title }}</h3>
                        <div class="p-price">${{ number_format($product->price, 2) }}</div>
                    </div>
                    <div class="p-action">
                        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary" style="width: 45px; height: 45px; justify-content: center; padding: 0; border-radius: 50%;">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                    </div>
                    <a href="{{ route('projects.show', $product->slug) }}" style="position: absolute; inset: 0; z-index: 1;"></a>
                </div>
                @empty
                    <div style="text-align: center; padding: 5rem; grid-column: 1/-1;">
                        <i class="fas fa-magnifying-glass" style="font-size: 3rem; color: var(--border); margin-bottom: 1.5rem;"></i>
                        <p style="color: var(--text-muted);">No products found in our collection.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
