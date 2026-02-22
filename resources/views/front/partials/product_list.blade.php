@foreach($products as $product)
<div class="product-card" data-aos="fade-up">
    <div class="product-img-wrapper">
        <a href="{{ route('products.show', $product->slug) }}">
            @if($product->hero_image)
                @if(Str::startsWith($product->hero_image, ['http://', 'https://']))
                    <img src="{{ $product->hero_image }}" alt="{{ $product->title }}" class="product-image" loading="lazy">
                @else
                    <img src="{{ asset($product->hero_image) }}" alt="{{ $product->title }}" class="product-image" loading="lazy">
                @endif
            @else
                <div style="width: 100%; height: 100%; background: #f8f9fa; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                    <i class="fas fa-image" style="font-size: 3rem;"></i>
                </div>
            @endif
        </a>
        
        @if($product->discount && $product->discount > 0)
            <div class="product-badge">
                -{{ round(($product->discount / ($product->price + $product->discount)) * 100) }}%
            </div>
        @elseif($product->created_at->diffInDays() < 30)
            <div class="product-badge new">
                New
            </div>
        @endif
        
        <div class="product-overlay">
            @if($product->price)
                <button onclick="addToCartAjax({{ $product->id }})" class="btn-icon" title="Add to Cart">
                    <i class="fas fa-shopping-cart"></i>
                </button>
            @endif
            <a href="{{ route('products.show', $product->slug) }}" class="btn-icon" title="Quick View">
                <i class="fas fa-eye"></i>
            </a>
            @if($product->price)
                <button onclick="addToWishlistAjax({{ $product->id }})" class="btn-icon" title="Add to Wishlist">
                    <i class="far fa-heart"></i>
                </button>
            @endif
        </div>
    </div>
    
    <div class="product-info-minimal">
        @if($product->category || $product->categories->count() > 0)
            <div style="margin-bottom: 0.5rem;">
                @if($product->category)
                    <span class="product-cat-label">{{ $product->category->name }}</span>
                @endif
                @foreach($product->categories->take(2) as $category)
                    <span class="product-cat-label" style="background: rgba(16, 185, 129, 0.1); color: #065f46;">{{ $category->name }}</span>
                @endforeach
                @if($product->categories->count() > 2)
                    <span class="product-cat-label" style="background: rgba(107, 114, 128, 0.1); color: #374151;">+{{ $product->categories->count() - 2 }} more</span>
                @endif
            </div>
        @else
            <div class="product-cat-label">General</div>
        @endif
        
        <h3 class="product-title-minimal">
            <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
        </h3>
        
        <!-- Star Rating -->
        <div class="product-rating">
            <div class="stars">
                @php
                    $rating = $product->reviews()->avg('rating') ?? 4.5; // Default rating if no reviews
                    $fullStars = floor($rating);
                    $hasHalfStar = ($rating - $fullStars) >= 0.5;
                @endphp
                
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $fullStars)
                        <i class="fas fa-star star"></i>
                    @elseif($i == $fullStars + 1 && $hasHalfStar)
                        <i class="fas fa-star-half-alt star"></i>
                    @else
                        <i class="fas fa-star star empty"></i>
                    @endif
                @endfor
            </div>
            <span class="rating-count">({{ $product->reviews()->count() ?? rand(15, 95) }} reviews)</span>
        </div>
        
        <div class="product-price-minimal">
            @if($product->price)
                @if($product->discount && $product->discount > 0)
                    <span class="price-old" style="color: #ef4444; text-decoration: line-through; font-size: 0.9rem;">₹{{ formatIndianPrice($product->price + $product->discount, 2) }}</span>
                @endif
                <span class="price-current" style="color: var(--primary); font-weight: 700;">₹{{ formatIndianPrice($product->price, 2) }}</span>
            @else
                <span class="price-current" style="color: var(--primary); font-weight: 700; font-size: 0.95rem;">Price on Request</span>
            @endif
        </div>

        <div class="product-actions-inline">
            @if($product->price)
                <button type="button" onclick="addToCartAjax({{ $product->id }})" class="btn-icon-action cart" title="Add to Cart">
                    <i class="fas fa-shopping-cart"></i>
                </button>
                <button type="button" onclick="addToWishlistAjax({{ $product->id }})" class="btn-icon-action" title="Add to Wishlist">
                    <i class="far fa-heart"></i>
                </button>
            @else
                <button type="button" onclick="openEnquireModal({{ $product->id }}, '{{ addslashes($product->title) }}')" class="btn-icon-action" style="background: var(--primary); color: white; flex: 1; width: auto; padding: 0 1rem;" title="Enquire Now">
                    <i class="fas fa-envelope"></i> Enquire Now
                </button>
            @endif
            <a href="{{ route('products.show', $product->slug) }}" class="btn-icon-action view" title="View Product">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
</div>
@endforeach
