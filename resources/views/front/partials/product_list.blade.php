@foreach($products as $product)
<div class="product-card" data-aos="fade-up">
    <div class="product-img-wrapper">
        <a href="{{ route('products.show', $product->slug) }}">
            @if($product->thumbnail)
                @if(Str::startsWith($product->thumbnail, ['http://', 'https://']))
                    <img src="{{ $product->thumbnail }}" alt="{{ $product->title }}" class="product-image" loading="lazy">
                @else
                    <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->title }}" class="product-image" loading="lazy">
                @endif
            @else
                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                    <i class="fas fa-image" style="font-size: 3rem;"></i>
                </div>
            @endif
        </a>
        @if($product->discount && $product->discount > 0)
            <div class="product-badge">
                -{{ round(($product->discount / ($product->price + $product->discount)) * 100) }}%
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
        <div class="product-price-minimal">
            @if($product->discount && $product->discount > 0)
                <span class="price-old">₹{{ number_format($product->price + $product->discount, 2) }}</span>
            @endif
            <span class="price-current">₹{{ number_format($product->price, 2) }}</span>
        </div>

        <div class="product-actions-inline">
            <button onclick="addToCartAjax({{ $product->id }})" class="btn-cart-icon" title="Add to Cart">
                <i class="fas fa-shopping-cart"></i>
            </button>
            <button onclick="addToWishlistAjax({{ $product->id }})" class="btn-wishlist-icon" title="Add to Wishlist">
                <i class="far fa-heart"></i>
            </button>
            <a href="{{ route('products.show', $product->slug) }}" class="btn-view-icon" title="Quick View">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
</div>
@endforeach
