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
            <a href="{{ route('cart.add', $product->id) }}" class="btn-icon" title="Add to Cart">
                <i class="fas fa-shopping-cart"></i>
            </a>
            <a href="{{ route('products.show', $product->slug) }}" class="btn-icon" title="Quick View">
                <i class="fas fa-eye"></i>
            </a>
            <a href="#" class="btn-icon" title="Add to Wishlist">
                <i class="far fa-heart"></i>
            </a>
        </div>
    </div>
    <div class="product-info-minimal">
        <div class="product-cat-label">{{ $product->category->name ?? 'General' }}</div>
        <h3 class="product-title-minimal">
            <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
        </h3>
        <div class="product-price-minimal">
            @if($product->discount && $product->discount > 0)
                <span class="price-old">${{ number_format($product->price + $product->discount, 2) }}</span>
            @endif
            <span class="price-current">${{ number_format($product->price, 2) }}</span>
        </div>

        <div class="product-actions-inline">
            <a href="{{ route('cart.add', $product->id) }}" class="btn-cart-inline" title="Add to Cart">
                <i class="fas fa-shopping-cart"></i> Add to Cart
            </a>
            <a href="{{ route('cart.add', ['id' => $product->id, 'redirect' => 'checkout']) }}" class="btn-buy-inline" title="Buy Now">
                <i class="fas fa-bolt"></i> Buy Now
            </a>
        </div>
    </div>
</div>
@endforeach
