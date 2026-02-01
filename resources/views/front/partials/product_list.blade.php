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
            <button onclick="addToCartAjax({{ $product->id }})" class="btn-icon" title="Add to Cart">
                <i class="fas fa-shopping-cart"></i>
            </button>
            <a href="{{ route('products.show', $product->slug) }}" class="btn-icon" title="Quick View">
                <i class="fas fa-eye"></i>
            </a>
            <button onclick="addToWishlistAjax({{ $product->id }})" class="btn-icon" title="Add to Wishlist">
                <i class="far fa-heart"></i>
            </button>
        </div>
    </div>
    
    <div class="product-info-minimal">
        <div class="product-cat-label">{{ $product->category->name ?? 'General' }}</div>
        
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
            @if($product->discount && $product->discount > 0)
                <span class="price-old">₹{{ number_format($product->price + $product->discount, 2) }}</span>
            @endif
            <span class="price-current">₹{{ number_format($product->price, 2) }}</span>
        </div>

        <div class="product-actions-inline">
            <button type="button" onclick="addToCartAjax({{ $product->id }})" class="btn-icon-action cart" title="Add to Cart">
                <i class="fas fa-shopping-cart"></i>
            </button>
            <button type="button" onclick="addToWishlistAjax({{ $product->id }})" class="btn-icon-action" title="Add to Wishlist">
                <i class="far fa-heart"></i>
            </button>
            <a href="{{ route('products.show', $product->slug) }}" class="btn-icon-action view" title="View Product">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
</div>
@endforeach
