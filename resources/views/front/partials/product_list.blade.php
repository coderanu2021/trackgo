@foreach($products as $product)
<div class="product-card" data-aos="fade-up">
    <div class="product-img-wrapper">
        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ $product->thumbnail ?? asset('placeholder.png') }}" alt="{{ $product->title }}" class="product-image">
        </a>
        @if($product->discount > 0)
            <div class="product-badge">SALE</div>
        @endif
        <div class="product-overlay">
            <a href="{{ route('cart.add', $product->id) }}" class="btn-icon" title="Add to Cart">
                <i class="fas fa-shopping-cart"></i>
            </a>
            <a href="{{ route('products.show', $product->slug) }}" class="btn-icon" title="Quick View">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
        <div class="product-info-minimal">
            <div class="product-cat-label">{{ $product->category->name ?? 'Uncategorized' }}</div>
            <h3 class="product-title-minimal">
                <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
            </h3>
            <div class="product-price-minimal">
                @if($product->discount > 0)
                    <span class="price-old">${{ number_format($product->price + $product->discount, 2) }}</span>
                @endif
                <span class="price-current">${{ number_format($product->price, 2) }}</span>
            </div>

            <div class="product-actions-inline" style="display: flex; gap: 0.5rem; margin-top: 1.5rem;">
                <a href="{{ route('cart.add', $product->id) }}" class="btn btn-cart-inline" title="Add to Cart" style="flex: 1; justify-content: center; padding: 0.6rem; font-size: 0.8rem; background: var(--bg-light); color: var(--secondary); border: 1px solid var(--border-soft); border-radius: 10px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 0.4rem; transition: 0.3s;">
                    <i class="fas fa-shopping-cart"></i> Add
                </a>
                <a href="{{ route('cart.add', ['id' => $product->id, 'redirect' => 'checkout']) }}" class="btn btn-buy-inline" title="Buy Now" style="flex: 1; justify-content: center; padding: 0.6rem; font-size: 0.8rem; background: var(--primary); color: white; border-radius: 10px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 0.4rem; transition: 0.3s;">
                    Buy Now
                </a>
            </div>
        </div>
</div>
@endforeach
