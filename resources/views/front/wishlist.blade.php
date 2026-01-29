@extends('layouts.front')

@section('title', 'My Wishlist - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<div class="container" style="padding: 4rem 0;">
    <div style="margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem; font-family: 'Outfit', sans-serif; font-weight: 800;">My Wishlist</h1>
        <p style="color: var(--text-muted); font-size: 1.1rem;">Items you've saved for later</p>
    </div>

    @if(count($wishlist) > 0)
        <div class="wishlist-grid">
            @foreach($wishlist as $id => $details)
                <div class="wishlist-item" data-id="{{ $id }}">
                    <div class="wishlist-img">
                        @if($details['image'])
                            @if(Str::startsWith($details['image'], ['http://', 'https://']))
                                <img src="{{ $details['image'] }}" alt="{{ $details['title'] }}" loading="lazy">
                            @else
                                <img src="{{ asset($details['image']) }}" alt="{{ $details['title'] }}" loading="lazy">
                            @endif
                        @else
                            <div class="no-image">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        <button onclick="removeFromWishlistAjax({{ $id }})" class="remove-wishlist-btn" title="Remove from Wishlist">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="wishlist-info">
                        <h3 class="wishlist-title">
                            <a href="{{ route('products.show', $details['slug']) }}">{{ $details['title'] }}</a>
                        </h3>
                        <div class="wishlist-price">₹{{ number_format($details['price'], 2) }}</div>
                        <div class="wishlist-actions">
                            <button onclick="addToCartAjax({{ $id }})" class="btn-cart-icon-large" title="Add to Cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                            <a href="{{ route('products.show', $details['slug']) }}" class="btn-view-icon-large" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-wishlist">
            <div class="empty-icon">
                <i class="far fa-heart"></i>
            </div>
            <h3>Your wishlist is empty</h3>
            <p>Start adding products you love to your wishlist</p>
            <a href="{{ route('shop') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i> Continue Shopping
            </a>
        </div>
    @endif
</div>

<style>
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    .wishlist-item {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: 0.3s;
        position: relative;
    }

    .wishlist-item:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-5px);
    }

    .wishlist-img {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .wishlist-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.3s;
    }

    .wishlist-item:hover .wishlist-img img {
        transform: scale(1.05);
    }

    .no-image {
        width: 100%;
        height: 100%;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 2rem;
    }

    .remove-wishlist-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 35px;
        height: 35px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
        color: var(--error);
    }

    .remove-wishlist-btn:hover {
        background: var(--error);
        color: white;
        transform: scale(1.1);
    }

    .wishlist-info {
        padding: 1.5rem;
    }

    .wishlist-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .wishlist-title a {
        color: var(--text-main);
        text-decoration: none;
    }

    .wishlist-title a:hover {
        color: var(--primary);
    }

    .wishlist-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 1rem;
        font-family: 'Outfit', sans-serif;
    }

    .wishlist-actions {
        display: flex;
        gap: 0.75rem;
    }

    .wishlist-actions .btn {
        flex: 1;
        padding: 0.75rem;
        font-size: 0.9rem;
        justify-content: center;
    }

    .empty-wishlist {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--text-light);
        margin-bottom: 1.5rem;
    }

    .empty-wishlist h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--text-main);
    }

    .empty-wishlist p {
        color: var(--text-muted);
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .wishlist-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .wishlist-actions {
            flex-direction: column;
        }

        .empty-wishlist {
            padding: 2rem 1rem;
        }
    }
</style>
@endsection