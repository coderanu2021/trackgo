@extends('layouts.front')

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
        padding: 0;
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
    @media (max-width: 1024px) {
        .features-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .features-grid { grid-template-columns: 1fr; gap: 1rem; }
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
            position: relative; /* Ensure z-index context if needed */
        }
        .cat-item {
            position: relative;
        }
        .cat-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border);
            transition: 0.3s;
            color: var(--text);
            text-decoration: none;
            width: 100%;
        }
        .cat-link:hover { padding-left: 1.5rem; color: var(--primary); background: #f8f9fa; }
        
        /* Submenu */
        .submenu {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            width: 250px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 0 8px 8px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 100;
        }
        .cat-item:hover .submenu {
            display: block;
        }
        .submenu-link {
            display: block;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f1f1f1;
            color: var(--text);
            transition: 0.2s;
            font-size: 0.95rem;
        }
        .submenu-link:hover {
            color: var(--primary);
            background: #f8f9fa;
            padding-left: 1.25rem;
        }
    </style>

    <div class="hero-grid">
        <!-- Sidebar -->
        <div class="category-sidebar">
            <div style="background:var(--secondary); color:white; padding:1rem; font-weight:600;">Browse Categories</div>
            @if(isset($categories))
                @foreach($categories as $cat)
                <div class="cat-item">
                    <a href="{{ route('category.show', $cat->slug) }}" class="cat-link" style="justify-content: space-between;">
                        <span style="display:flex; align-items:center; gap:0.75rem;">
                            @if($cat->icon) <i class="{{ $cat->icon }}"></i> @endif
                            {{ $cat->name }}
                        </span>
                        @if($cat->children->count() > 0)
                            <i class="fas fa-chevron-right" style="font-size: 0.7rem; color: #ccc;"></i>
                        @endif
                    </a>
                    
                    @if($cat->children->count() > 0)
                    <div class="submenu">
                        @foreach($cat->children as $child)
                        <a href="{{ route('category.show', $child->slug) }}" class="submenu-link">
                            {{ $child->name }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            @endif
        </div>

        <!-- Slider -->
        <!-- Slider -->
        <div class="hero-slider" style="position: relative;">
            @forelse($hero_slides as $index => $banner)
            <div class="hero-slide" style="display: {{ $index == 0 ? 'block' : 'none' }}; width: 100%; animation: fadeEffect 1s;">
                @if($banner->link)
                <a href="{{ $banner->link }}" style="display:block; width:100%;">
                @endif
                
                @if($banner->image)
                <img src="{{ $banner->image }}" alt="{{ $banner->title }}" style="width: 100%; height: auto; border-radius: 8px; display: block; object-fit: cover;">
                @else
                <div style="width: 100%; height: 400px; background: #ddd; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                    <span style="font-size: 1.5rem; color: #666;">{{ $banner->title }}</span>
                </div>
                @endif

                @if($banner->link)
                </a>
                @endif
            </div>
            @empty
            <div class="hero-slide" style="display: block; width: 100%;">
                 <div style="width: 100%; height: 400px; background: #ddd; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                    <span style="font-size: 1.5rem; color: #666;">Welcome to Our Store</span>
                </div>
            </div>
            @endforelse
            
            @if($hero_slides->count() > 1)
            <div style="position: absolute; bottom: 1rem; left: 50%; transform: translateX(-50%); display: flex; gap: 0.5rem;">
                @foreach($hero_slides as $index => $banner)
                <span class="dot" onclick="currentSlide({{ $index }})" style="height: 10px; width: 10px; background-color: #bbb; border-radius: 50%; display: inline-block; cursor: pointer;"></span>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Banners -->
        <div style="display:flex; flex-direction:column; gap:2rem;">
            <div style="flex:1; background:#edf2f7; border-radius:8px; padding:2rem; display:flex; flex-direction:column; justify-content:center;">
                <h3>Summer Offer</h3>
                <p class="text-primary">New Arrival</p>
            </div>
            <div style="flex:1; background:#2b3445; color:white; border-radius:8px; padding:2rem; display:flex; flex-direction:column; justify-content:center;">
                <h3>AMLED Sound</h3>
                <p>Headphone</p>
            </div>
        </div>
    </div>
    <style>
        @media (max-width: 768px) {
            .hero-slider { padding: 0; }
            .hero-content h1 { font-size: 2rem; }
            .hero-slide { flex-direction: column !important; text-align: center; }
            .hero-slide div:last-child { justify-content: center !important; margin-top: 2rem; }
            .about-grid { grid-template-columns: 1fr !important; gap: 2.5rem !important; }
            .about-img-container { order: 2; }
            .about-content { order: 1; text-align: center; }
            .about-content div { margin: 0 auto 2rem !important; }
        }
    </style>
</section>

</section>

<!-- Top Brands -->
@if(isset($brands) && $brands->count() > 0)
<section class="container" style="padding: 3rem 0; margin-bottom: 2rem;">
    <div class="section-header">
        <h2 class="section-title">Our Top Brands</h2>
        <!-- <a href="#" class="text-primary">View All <i class="fas fa-arrow-right"></i></a> -->
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1.5rem;">
        @foreach($brands as $brand)
            <a href="{{ $brand->url ?? '#' }}" class="brand-item" title="{{ $brand->name }}" target="{{ $brand->url ? '_blank' : '_self' }}"
               style="background: white; border: 1px solid var(--border); border-radius: 8px; padding: 1.5rem; display: flex; align-items: center; justify-content: center; height: 100px; transition: all 0.3s; position: relative; overflow: hidden;">
                <img src="{{ Str::startsWith($brand->logo, ['http://', 'https://']) ? $brand->logo : asset($brand->logo) }}" alt="{{ $brand->name }}" style="max-width: 80%; max-height: 80%; object-fit: contain; filter: grayscale(100%); opacity: 0.7; transition: all 0.3s;">
                <style>
                    .brand-item:hover { border-color: var(--primary); box-shadow: 0 5px 15px rgba(0,0,0,0.05); transform: translateY(-3px); }
                    .brand-item:hover img { filter: grayscale(0); opacity: 1; }
                </style>
            </a>
        @endforeach
    </div>
</section>
@endif

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

<!-- About Us Section -->
<section style="padding: 6rem 0; background: var(--white);">
    <div class="container">
        <div class="about-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
            <div class="about-img-container" style="position: relative;">
                <div style="position: absolute; top: -20px; left: -20px; width: 100px; height: 100px; background: var(--primary-soft); border-radius: 50%; z-index: 0;"></div>
                <img src="{{ asset('uploads/about/home_about.png') }}" alt="About Us" style="width: 100%; border-radius: 24px; position: relative; z-index: 1; box-shadow: var(--shadow-lg);">
            </div>
            <div class="about-content">
                <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1.5rem; color: var(--secondary); letter-spacing: -0.02em;">Crafting Digital Excellence for Your Business</h2>
                <div style="width: 60px; height: 4px; background: var(--primary); border-radius: 2px; margin-bottom: 2rem;"></div>
                <p style="font-size: 1.15rem; line-height: 1.8; color: var(--text-muted); margin-bottom: 1.5rem;">
                    At <strong>{{ $settings['site_name'] ?? 'TrackGo' }}</strong>, we are dedicated to providing the most advanced project tracking and order management solutions. Our mission is to empower teams with precision tools that simplify complex workflows and drive measurable results.
                </p>
                <p style="font-size: 1.15rem; line-height: 1.8; color: var(--text-muted); margin-bottom: 2.5rem;">
                    With a focus on innovation and user-centric design, we help businesses across the globe transform their digital operations into efficient, high-performing powerhouses.
                </p>
                <a href="{{ route('about') }}" class="btn btn-primary" style="padding: 1rem 2.5rem; border-radius: 12px; font-weight: 800;">
                    LEARN MORE <i class="fas fa-arrow-right" style="margin-left: 0.5rem; font-size: 0.8rem;"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Projects / Products -->
<section class="container" style="padding: 4rem 0;">
    <div class="section-header">
        <h2 class="section-title">New Arrivals</h2>
        <a href="{{ route('shop') }}" class="text-primary">View All</a>
    </div>

    <div class="product-grid">
        @forelse($products as $product)
        <div class="product-card">
            <div class="product-img">
                @if($product->thumbnail)
                    <img src="{{ $product->thumbnail }}" alt="{{ $product->title }}">
                @else
                    <span>No Image</span>
                @endif
            </div>
            <div class="product-info">
                <div class="product-category">{{ $product->category->name ?? 'General' }}</div>
                <h3 class="product-title">
                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                </h3>
                <div class="flex justify-between items-center">
                    @if($product->is_enquiry)
                        <a href="{{ route('products.show', $product->slug) }}" class="btn-shop" style="padding: 0.5rem 1rem; font-size: 0.8rem; background: var(--secondary);">Enquire Now</a>
                    @else
                        <span class="product-price">${{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('cart.add', $product->id) }}" class="btn-shop" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Add to Cart</a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align:center;">No items found.</div>
        @endforelse
    </div>
</section>



<!-- Blog Section -->
<section class="container" style="padding: 4rem 0; background: #f9f9f9; border-radius: 12px; margin-bottom: 4rem;">
    <div class="section-header">
        <h2 class="section-title">Latest Articles</h2>
        <a href="{{ route('blogs.index') }}" class="text-primary">View All Posts</a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2.5rem;">
        @forelse($blogs as $blog)
        <article style="background: white; border-radius: 12px; overflow: hidden; border: 1px solid var(--border); transition: 0.3s;" 
                 onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.05)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            @if($blog->image)
                <div style="height: 200px; overflow: hidden;">
                    <img src="{{ $blog->image }}" alt="{{ $blog->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            @endif
            <div style="padding: 2rem;">
                <div style="font-size: 0.85rem; color: var(--primary); font-weight: 600; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    {{ $blog->created_at->format('M d, Y') }}
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1rem; color: var(--secondary); line-height: 1.4;">
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
                <a href="{{ route('blogs.show', $blog->slug) }}" style="font-weight: 700; color: var(--secondary); display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem;">
                    READ ARTICLE <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                </a>
            </div>
        </article>
        @empty
        <div style="grid-column: 1/-1; text-align:center;">No blog posts available.</div>
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
    const slides = document.querySelectorAll(".hero-slide");
    const dots = document.querySelectorAll(".dot");

    function showSlides() {
        if (slides.length === 0) return;
        
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}    
        
        for (let i = 0; i < dots.length; i++) {
            dots[i].style.backgroundColor = "#bbb";
        }
        
        slides[slideIndex-1].style.display = "flex";  
        if (dots.length > 0) {
            dots[slideIndex-1].style.backgroundColor = "#717171";
        }
        
        setTimeout(showSlides, 5000); // Change image every 5 seconds
    }

    function currentSlide(n) {
        // Reset timer? For simplicity, just show.
        // To do this properly requires clearing timeout, but simple implementation:
        // Just setting styles manually.
        if (slides.length === 0) return;
        
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        for (let i = 0; i < dots.length; i++) {
            dots[i].style.backgroundColor = "#bbb";
        }
        
        slides[n].style.display = "flex";
        if (dots.length > 0) {
            dots[n].style.backgroundColor = "#717171";
        }
        slideIndex = n + 1; // Sync auto-advance
    }

    document.addEventListener('DOMContentLoaded', () => {
        showSlides();
    });
</script>
@endsection
