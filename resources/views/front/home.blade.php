@extends('layouts.front')

@section('content')



<style>
    /* Hero Section - Zenis Grid */
    .hero-section {
        padding: 2rem 0;
        background: #fcfcfc;
    }
    .hero-grid {
        display: grid;
        grid-template-columns: 260px 1fr 280px; /* Sidebar | Slider | Promo Banners */
        gap: 1.5rem;
    }
    @media (max-width: 1200px) {
        .hero-grid { grid-template-columns: 240px 1fr; }
        .hero-banners { display: none; } /* Hide right banners on medium screens */
    }
    @media (max-width: 992px) {
        .hero-grid { grid-template-columns: 1fr; }
        .category-sidebar { display: none; }
    }

    /* Category Sidebar */
    .category-sidebar {
        background: white;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        border: 1px solid var(--border);
    }

    /* Category Sidebar */
    .category-sidebar {
        background: white;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        border: 1px solid var(--border);
    }
    .cat-header {
        background: var(--primary);
        color: white;
        padding: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .cat-list {
        display: flex;
        flex-direction: column;
    }
    .cat-link {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid var(--border-soft);
        font-size: 0.9rem;
        color: var(--text-main);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: 0.2s;
    }
    .cat-link:last-child { border-bottom: none; }
    .cat-link:hover {
        background: #f9f9f9;
        color: var(--primary);
        padding-left: 1.25rem;
    }

    /* Slider */
    .hero-slider-container {
        border-radius: var(--radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        position: relative;
    }
    .hero-slide {
        display: none;
        width: 100%;
        height: 100%;
        animation: fade 1s;
    }
    .hero-slide img {
        width: 100%;
        height: 420px;
        object-fit: cover;
    }

    /* Right Banners */
    .hero-banners {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .promo-banner {
        flex: 1;
        border-radius: var(--radius-md);
        overflow: hidden;
        position: relative;
        display: flex;
        align-items: center;
        padding: 1.5rem;
        color: white;
        background-size: cover;
        background-position: center;
        box-shadow: var(--shadow-sm);
    }
    .promo-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.3);
    }
    .promo-content {
        position: relative;
        z-index: 1;
    }

    /* Features - Zenis Clean */
    .features-section {
        padding: 3rem 0;
        background: var(--white);
    }
    .features-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }
    @media (max-width: 1024px) {
        .features-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .features-grid { grid-template-columns: 1fr; gap: 1rem; }
    }
    .feature-item {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 1.5rem;
        background: white;
        /* No border, just subtle shadow or clean layout */
        border: 1px solid transparent; 
        border-radius: var(--radius-md);
        transition: 0.3s;
    }
    .feature-item:hover {
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transform: translateY(-5px);
    }
    .feature-icon {
        font-size: 2.5rem;
        color: var(--primary);
        /* Zenis often uses a soft circle background for icons */
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-soft);
        border-radius: 50%;
        transition: 0.3s;
    }
    .feature-item:hover .feature-icon {
        background: var(--primary);
        color: white;
    }

    /* Section Headers - Zenis Tabs Style */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        border-bottom: 2px solid var(--border);
        padding-bottom: 10px;
    }
    .section-title { margin: 0; }
    .section-title h2 {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1a1a1a; /* Force black color for headings */
        margin: 0;
        position: relative;
    }
    /* The active tab underline effect */
    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: -12px; /* connects to border-bottom of container */
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--primary);
    }
    
    .section-tabs {
        display: flex;
        gap: 20px;
    }
    .sec-tab {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        position: relative;
        transition: 0.3s;
    }
    .sec-tab:hover, .sec-tab.active {
        color: var(--primary);
    }
    .sec-tab.active::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--primary);
    }

    .view-all-btn {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--secondary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: 0.2s;
        text-transform: uppercase;
        border-bottom: 2px solid transparent;
    }
    .view-all-btn:hover { 
        color: var(--primary); 
    }

    /* Product Card - Zenis Premium (Existing) */
    .product-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        overflow: hidden;
        transition: 0.3s;
        position: relative;
        group: p-card;
    }
    .product-card:hover {
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08); 
        transform: translateY(-5px);
        border-color: transparent;
    }
    .p-img-container {
        height: 260px;
        position: relative;
        background: #f8f8f8;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .p-img-container img {
        max-width: 90%;
        max-height: 90%;
        transition: 0.5s;
    }
    .product-card:hover .p-img-container img {
        transform: scale(1.08);
    }
    
    .p-actions {
        position: absolute;
        top: 1rem;
        right: -50px;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        transition: 0.3s;
    }
    .product-card:hover .p-actions {
        right: 1rem;
    }
    .p-action-btn {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--secondary);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        font-size: 0.9rem;
        transition: 0.2s;
    }
    .p-action-btn:hover {
        background: var(--primary);
        color: white;
    }

    .p-details {
        padding: 1.25rem;
    }
    .p-cat {
        font-size: 0.8rem;
        text-transform: uppercase;
        color: var(--text-light);
        margin-bottom: 0.35rem;
        letter-spacing: 0.05em;
    }
    .p-title {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .p-title a:hover { color: var(--primary); }
    .p-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.75rem;
    }
    .p-price {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--primary);
    }
    .add-cart-btn {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        border-bottom: 2px solid var(--border);
        padding-bottom: 2px;
        transition: 0.2s;
    }
    .add-cart-btn:hover {
        color: var(--primary);
        border-color: var(--primary);
    }

    /* Adjust Grid for smaller space */
    .product-grid-compact {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }
    @media (max-width: 768px) {
        .product-grid-compact {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
        }
    }
    
    /* Product Card Improvements */
    .product-card .p-img-container img {
        transition: transform 0.3s ease;
    }
    .product-card:hover .p-img-container img {
        transform: scale(1.05);
    }
    
    /* Price styling improvements */
    .p-price {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.25rem;
    }
</style>

<!-- Hero -->
<section class="hero-section" style="padding-top: 0; margin-top: 0;">
    <div class="container">
    <div class="hero-grid">
        <!-- Sidebar (Visual continuation of Header's Vertical Menu) -->
        <div class="category-sidebar" style="border-top-left-radius: 0; border-top-right-radius: 0; border-top: none;">
            <div class="cat-list">
                @if(isset($categories))
                    @foreach($categories->take(8) as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="cat-link">
                        <span style="display:flex; align-items:center; gap:0.75rem;">
                            @if($cat->icon) <i class="{{ $cat->icon }}" style="width:20px; text-align:center;"></i> @endif
                            {{ $cat->name }}
                        </span>
                        @if($cat->children->count() > 0)
                            <i class="fas fa-chevron-right" style="font-size: 0.7rem; color: #ccc;"></i>
                        @endif
                    </a>
                    @endforeach
                    <a href="{{ route('shop') }}" class="cat-link" style="font-weight:700; color:var(--primary);">
                        <span>View All Categories</span>
                        <i class="fas fa-plus-circle"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- Slider -->
        <div class="hero-slider-container" style="margin-top: 15px;">
            @forelse($hero_slides as $index => $banner)
            <div class="hero-slide" style="display: {{ $index == 0 ? 'block' : 'none' }};">
                @if($banner->link) <a href="{{ $banner->link }}" style="display:block; height:100%;"> @endif
                
                @if($banner->image)
                    <img src="{{ $banner->image }}" alt="{{ $banner->title ?? 'Banner' }}" style="width: 100%; height: 420px; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 420px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); display: flex; align-items: center; justify-content: center; color: white;">
                        <div style="text-align: center; padding: 2rem;">
                            <h2 style="font-size: 2.5rem; margin-bottom: 1rem; color: white;">{{ $banner->title ?? 'Welcome to ' . ($settings['site_name'] ?? 'TrackGo') }}</h2>
                            <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9;">{{ $banner->subtitle ?? 'Discover premium products and manage your projects with ease.' }}</p>
                            @if($banner->link)
                                <a href="{{ $banner->link }}" class="btn" style="background: white; color: var(--primary); padding: 1rem 2rem; border-radius: 50px; font-weight: 700; text-transform: uppercase;">Shop Now</a>
                            @endif
                        </div>
                    </div>
                @endif

                @if($banner->link) </a> @endif
            </div>
            @empty
            <div class="hero-slide" style="display: block;">
                 <div style="width: 100%; height: 420px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); display: flex; align-items: center; justify-content: center; color: white;">
                    <div style="text-align: center; padding: 2rem;">
                        <h2 style="font-size: 2.5rem; margin-bottom: 1rem; color: white;">Welcome to {{ $settings['site_name'] ?? 'TrackGo' }}</h2>
                        <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9;">Discover premium products and manage your projects with ease.</p>
                        <a href="{{ route('shop') }}" class="btn" style="background: white; color: var(--primary); padding: 1rem 2rem; border-radius: 50px; font-weight: 700; text-transform: uppercase;">Shop Now</a>
                    </div>
                </div>
            </div>
            @endforelse
            
            <!-- Slider Dots -->
            @if($hero_slides->count() > 1)
            <div style="position: absolute; bottom: 1.5rem; left: 50%; transform: translateX(-50%); display: flex; gap: 0.5rem; z-index: 10;">
                @foreach($hero_slides as $index => $banner)
                <span class="dot" onclick="currentSlide({{ $index }})" style="height: 12px; width: 12px; background-color: rgba(255,255,255,0.5); border-radius: 50%; display: inline-block; cursor: pointer; transition: 0.3s; border: 2px solid white;"></span>
                @endforeach
            </div>
            <style> .dot.active { background-color: white !important; transform: scale(1.2); } </style>
            @endif
        </div>

        <!-- Right Banners -->
        <div class="hero-banners" style="margin-top: 15px;">
            <div class="promo-banner" style="background-color: #1a1a1a; background-image: url('{{ asset('uploads/banners/promo1.jpg') }}');">
                <div class="promo-content">
                    <div style="color: #ffc107; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem;">New Arrival</div>
                    <h3 style="font-size: 1.5rem; line-height: 1.2; margin-bottom: 1rem;">Galaxy S24 Ultra</h3>
                    <a href="{{ route('shop') }}" style="color: white; text-decoration: underline; font-size: 0.9rem;">Shop Now</a>
                </div>
            </div>
            <div class="promo-banner" style="background-color: #FF6B00; background-image: url('{{ asset('uploads/banners/promo2.jpg') }}');">
                <div class="promo-content">
                    <div style="color: rgba(255,255,255,0.8); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem;">Best Seller</div>
                    <h3 style="font-size: 1.5rem; line-height: 1.2; margin-bottom: 1rem;">Headphone Pro</h3>
                    <a href="{{ route('shop') }}" style="color: white; text-decoration: underline; font-size: 0.9rem;">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features-section">
    <div class="container">
    <div class="features-grid">
        <div class="feature-item">
            <div class="feature-icon"><i class="fas fa-shipping-fast"></i></div>
            <div>
                <div style="font-weight:700; color:var(--secondary);">Free Shipping</div>
                <div style="font-size:0.85rem; color:var(--text-muted); margin-top:0.2rem;">On orders over $100</div>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
            <div>
                <div style="font-weight:700; color:var(--secondary);">Secure Payment</div>
                <div style="font-size:0.85rem; color:var(--text-muted); margin-top:0.2rem;">100% secure payment</div>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon"><i class="fas fa-gift"></i></div>
            <div>
                <div style="font-weight:700; color:var(--secondary);">Gif Voucher</div>
                <div style="font-size:0.85rem; color:var(--text-muted); margin-top:0.2rem;">Gift box service available</div>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon"><i class="fas fa-headset"></i></div>
            <div>
                <div style="font-weight:700; color:var(--secondary);">24/7 Support</div>
                <div style="font-size:0.85rem; color:var(--text-muted); margin-top:0.2rem;">Ready support</div>
            </div>
        </div>
    </div>
</section>

<!-- Top Brands -->
@if(isset($brands) && $brands->count() > 0)
<section style="padding-bottom: 4rem;">
    <div class="container">
    <div class="section-header">
        <div class="section-title">
            <h2>Top Brands</h2>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 1rem;">
        @foreach($brands as $brand)
            <a href="{{ $brand->url ?? '#' }}" class="brand-item" title="{{ $brand->name }}" target="{{ $brand->url ? '_blank' : '_self' }}"
               style="background: white; border: 1px solid var(--border); border-radius: var(--radius-md); padding: 1rem; display: flex; align-items: center; justify-content: center; height: 90px; transition: all 0.3s; position: relative; overflow: hidden;">
                <img src="{{ Str::startsWith($brand->logo, ['http://', 'https://']) ? $brand->logo : asset($brand->logo) }}" alt="{{ $brand->name }}" style="max-width: 80%; max-height: 80%; object-fit: contain; filter: grayscale(100%); opacity: 0.7; transition: all 0.3s;">
                <style>
                    .brand-item:hover { border-color: var(--primary); box-shadow: 0 5px 15px rgba(0,0,0,0.05); transform: translateY(-3px); }
                    .brand-item:hover img { filter: grayscale(0); opacity: 1; }
                </style>
            </a>
        @endforeach
    </div>
    </div>
</section>
@endif

<!-- Latest Products -->
<section style="padding-bottom: 4rem;">
    <div class="container">
        <div class="section-header">
            <div class="section-title">
                <h2>Latest Products</h2>
            </div>
            <a href="{{ route('shop') }}" class="view-all-btn">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        @if($products->count() > 0)
            <div class="product-grid-compact">
                @foreach($products->take(8) as $product)
                    <div class="product-card">
                        <div class="p-img-container">
                            @if($product->thumbnail)
                                <img src="{{ $product->thumbnail }}" alt="{{ $product->title }}" loading="lazy">
                            @else
                                <div style="width: 100%; height: 100%; background: #f5f5f5; display: flex; align-items: center; justify-content: center; color: #999;">
                                    <i class="fas fa-image" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            
                            <div class="p-actions">
                                <a href="#" class="p-action-btn" title="Add to Wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="{{ route('products.show', $product->slug) }}" class="p-action-btn" title="Quick View">
                                    <i class="far fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="p-details">
                            <div class="p-cat">{{ $product->category->name ?? 'General' }}</div>
                            <h3 class="p-title">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                            </h3>
                            <div class="p-footer">
                                <div class="p-price">
                                    ₹{{ number_format($product->price, 2) }}
                                </div>
                                <a href="#" class="add-cart-btn" onclick="addToCart({{ $product->id }})">
                                    Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem 0; background: #f9f9f9; border-radius: var(--radius-md);">
                <i class="fas fa-box-open" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                <h3 style="color: #666; margin-bottom: 0.5rem;">No Products Available</h3>
                <p style="color: #999; margin-bottom: 1.5rem;">Products will appear here once they are added.</p>
                @if(Auth::check() && Auth::user()->isAdmin())
                    <a href="{{ route('admin.products.create') }}" style="background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-md); font-weight: 600;">
                        Add First Product
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>

    <!-- Blog Section -->
    <section style="padding: 0 0 4rem;">
    <div class="container">
    <div class="section-header">
        <div class="section-title">
            <h2>Latest Articles</h2>
        </div>
        <a href="{{ route('blogs.index') }}" class="view-all-btn">
            View All <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2.5rem;">
        @forelse($blogs as $blog)
        <article style="background: white; border-radius: 12px; overflow: hidden; border: 1px solid var(--border); transition: 0.3s;" 
                 onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.05)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            @if($blog->image)
                <div style="height: 200px; overflow: hidden;">
                    <img src="{{ $blog->image }}" alt="{{ $blog->title }}" style="width: 100%; height: 100%; object-fit: cover;" 
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display: none; height: 200px; background: #f5f5f5; align-items: center; justify-content: center; color: #999;">
                        <i class="fas fa-image" style="font-size: 2rem;"></i>
                    </div>
                </div>
            @else
                <div style="height: 200px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; color: #999;">
                    <i class="fas fa-image" style="font-size: 2rem;"></i>
                </div>
            @endif
            <div style="padding: 2rem;">
                <div style="font-size: 0.85rem; color: var(--primary); font-weight: 600; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    {{ $blog->created_at->format('M d, Y') }}
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1rem; color: #1a1a1a; line-height: 1.4;">
                    <a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->title }}</a>
                </h3>
                <p style="color: var(--text); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                    @php
                        $summary = '';
                        if (is_array($blog->content)) {
                            foreach($blog->content as $block) {
                                if ($block['type'] === 'text') {
                                    $summary .= ($block['data']['content'] ?? '') . ' ';
                                }
                            }
                        } else {
                            $summary = $blog->content;
                        }
                    @endphp
                    {{ Str::limit(strip_tags($summary), 120) }}
                </p>
                <a href="{{ route('blogs.show', $blog->slug) }}" style="font-weight: 700; color: #1a1a1a; display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem;">
                    READ ARTICLE <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                </a>
            </div>
        </article>
        @empty
        <div style="grid-column: 1/-1; text-align:center; padding: 2rem; color: #666;">
            <i class="fas fa-newspaper" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem;"></i>
            <p>No blog posts available yet.</p>
        </div>
        @endforelse
    </div>
</section>

<style>
    @keyframes fadeEffect {
        from {opacity: 0.4;} 
        to {opacity: 1;}
    }
</style>

<script>
    let slideIndex = 0;
    let slideTimer = null;
    const slides = document.querySelectorAll(".hero-slide");
    const dots = document.querySelectorAll(".dot");

    function showSlides() {
        if (slides.length <= 1) return; // Don't run if only one slide or no slides
        
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}    
        
        for (let i = 0; i < dots.length; i++) {
            dots[i].style.backgroundColor = "#bbb";
        }
        
        if (slides[slideIndex-1]) {
            slides[slideIndex-1].style.display = "block";  
        }
        if (dots.length > 0 && dots[slideIndex-1]) {
            dots[slideIndex-1].style.backgroundColor = "#717171";
        }
        
        // Clear existing timer and set new one
        if (slideTimer) clearTimeout(slideTimer);
        slideTimer = setTimeout(showSlides, 5000);
    }

    function currentSlide(n) {
        if (slides.length === 0) return;
        
        // Clear auto-advance timer
        if (slideTimer) clearTimeout(slideTimer);
        
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        for (let i = 0; i < dots.length; i++) {
            dots[i].style.backgroundColor = "#bbb";
        }
        
        if (slides[n]) {
            slides[n].style.display = "block";
        }
        if (dots.length > 0 && dots[n]) {
            dots[n].style.backgroundColor = "#717171";
        }
        slideIndex = n + 1;
        
        // Restart auto-advance
        if (slides.length > 1) {
            slideTimer = setTimeout(showSlides, 5000);
        }
    }

    function addToCart(productId) {
        // Use the existing GET route for adding to cart
        window.location.href = `/cart/add/${productId}`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (slides.length > 1) {
            showSlides();
        }
    });
</script>
@endsection
