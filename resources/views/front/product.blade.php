@extends('layouts.front')

@section('title', $page->meta_title ?? $page->title)

@push('styles')
<style>
    /* Product Hero Section */
    .product-hero {
        background: white;
        padding: 4rem 0;
        border-bottom: 1px solid var(--border);
    }
    .product-grid {
        display: grid;
        grid-template-columns: 40% 1fr;
        gap: 4rem;
        align-items: start;
    }
    @media (max-width: 992px) {
        .product-grid { grid-template-columns: 1fr; gap: 2rem; }
    }

    /* Gallery Styles */
    .gallery-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .main-image {
        width: 100%;
        aspect-ratio: 1/1;
        object-fit: cover;
        border-radius: 24px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        cursor: zoom-in;
        transition: transform 0.3s ease;
    }
    .main-image:hover {
        transform: scale(1.02);
    }
    .thumbnails {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        scrollbar-width: thin;
        scrollbar-color: var(--primary) #f1f1f1;
    }
    .thumbnails::-webkit-scrollbar {
        height: 6px;
    }
    .thumbnails::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .thumbnails::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 3px;
    }
    .thumb {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .thumb:hover {
        border-color: var(--primary);
        transform: scale(1.05);
    }
    .thumb.active {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
    }

    /* Info Styles */
    .product-info h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0 0 1rem;
        color: var(--secondary);
        line-height: 1.2;
    }
    .price-tag {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: baseline;
        gap: 0.5rem;
    }
    .price-old {
        font-size: 1.25rem;
        color: #ef4444;
        text-decoration: line-through;
        font-weight: 400;
    }
    
    /* Discount Badge Styles */
    .product-discount-badge {
        animation: pulse 2s infinite;
    }
    .discount-badge {
        animation: slideInLeft 0.5s ease-out;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    @keyframes slideInLeft {
        0% { transform: translateX(-20px); opacity: 0; }
        100% { transform: translateX(0); opacity: 1; }
    }
    
    .stock-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        background: #ecfdf5;
        color: #059669;
        margin-bottom: 2rem;
    }
    .stock-out { background: #fef2f2; color: #dc2626; }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    .btn-large {
        padding: 1.25rem;
        border-radius: 16px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        transition: all 0.3s;
    }
        gap: 0.75rem;
        transition: all 0.3s;
    }
    .btn-cart { background: var(--bg-light); color: var(--secondary); border: 1px solid var(--border); }
    .btn-buy { background: var(--primary); color: white; border: none; }
    .btn-buy:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3); }

    /* Page Builder Styles */
    .content-area { padding: 4rem 0; }
    .block-wrapper { margin-bottom: 2rem; }
    
    /* Hero Stats Block */
    .hero-stats {
        padding: 4rem 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }
    .hero-stats-content h2 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1.5rem; line-height: 1.2; }
    .hero-stats-content p { font-size: 1.25rem; color: #64748b; margin-bottom: 2rem; }
    .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
    .stat-card { background: #f8fafc; padding: 1.5rem; border-radius: 12px; border-left: 4px solid var(--primary); }
    .stat-value { font-size: 2rem; font-weight: 800; color: var(--secondary); display: block; }
    .stat-label { font-size: 0.9rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
    .hero-stats-image img { width: 100%; border-radius: 20px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }

    /* Timeline Block */
    .timeline { position: relative; max-width: 800px; margin: 0 auto; }
    .timeline::before { content: ''; position: absolute; left: 50%; width: 4px; height: 100%; background: #e2e8f0; transform: translateX(-50%); }
    .timeline-item { padding: 1rem 0; position: relative; width: 50%; box-sizing: border-box; }
    .timeline-item:nth-child(odd) { left: 0; padding-right: 3rem; text-align: right; }
    .timeline-item:nth-child(even) { left: 50%; padding-left: 3rem; }
    .timeline-dot { position: absolute; width: 20px; height: 20px; background: var(--primary); border-radius: 50%; top: 1.5rem; z-index: 10; }
    .timeline-item:nth-child(odd) .timeline-dot { right: -12px; }
    .timeline-item:nth-child(even) .timeline-dot { left: -12px; }
    .timeline-content { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); text-align: left; }
    .timeline-item:nth-child(odd) .timeline-content { text-align: right; }
    .timeline-item:nth-child(even) .timeline-content { text-align: left; }
    .timeline-year { font-size: 0.9rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem; }
    .timeline-title { font-size: 1.25rem; font-weight: 700; margin: 0 0 0.5rem; }
    .timeline-badge { display: inline-block; background: #e0e7ff; color: var(--primary); padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; }

    /* Split Content Block */
    .split-container { display: flex; align-items: center; gap: 4rem; }
    .split-container.reverse { flex-direction: row-reverse; }
    .split-content { flex: 1; }
    .split-image { flex: 1; }
    .split-image img { width: 100%; border-radius: 20px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
    .split-title { font-size: 2rem; font-weight: 800; margin-bottom: 1rem; }
    .split-desc { font-size: 1.1rem; color: #64748b; margin-bottom: 2rem; }
    .split-stats { display: flex; gap: 2rem; }
    .split-stat-item strong { display: block; font-size: 1.5rem; color: var(--primary); }
    .split-stat-item span { font-size: 0.9rem; color: #64748b; }

    /* Tabs Block */
    .tabs-header { display: flex; gap: 1rem; border-bottom: 1px solid #e2e8f0; margin-bottom: 1.5rem; }
    .tab-btn { padding: 0.75rem 1.5rem; border: none; background: none; font-weight: 700; color: #64748b; cursor: pointer; transition: 0.3s; border-bottom: 3px solid transparent; }
    .tab-btn.active { color: var(--primary); border-bottom-color: var(--primary); }
    .tab-pane { display: none; }
    .tab-pane.active { display: block; }

    /* Columns Block */
    .columns-container {
        display: flex;
        gap: 2rem;
        margin-bottom: 2rem;
    }
    .column {
        flex: 1;
        min-width: 0;
    }
    @media (max-width: 768px) {
        .columns-container {
            flex-direction: column;
        }
    }

    @media (max-width: 768px) {
        .hero-stats, .split-container { grid-template-columns: 1fr; flex-direction: column !important; gap: 2rem; }
        .timeline::before { left: 20px; }
        .timeline-item { width: 100% !important; left: 0 !important; padding-left: 3rem !important; padding-right: 0 !important; text-align: left !important; }
        .timeline-dot { left: 10px !important; }
        .timeline-content { text-align: left !important; }
    }

    /* Reviews Styles */
    .reviews-section { padding: 4rem 0; background: #f8fafc; border-top: 1px solid var(--border); }
    .review-card { background: white; padding: 2rem; border-radius: 20px; box-shadow: var(--shadow-sm); margin-bottom: 2rem; border: 1px solid var(--border-soft); }
    .review-header { display: flex; justify-content: space-between; margin-bottom: 1rem; }
    .review-user { font-weight: 800; color: var(--secondary); font-size: 1.1rem; }
    .review-date { color: var(--text-muted); font-size: 0.85rem; }
    .star-rating { color: #ffc107; font-size: 0.9rem; }
    .review-comment { line-height: 1.6; color: var(--text-main); margin-bottom: 1.5rem; }
    .review-images { display: flex; gap: 0.75rem; flex-wrap: wrap; }
    .review-img { width: 100px; height: 100px; border-radius: 12px; object-fit: cover; cursor: pointer; transition: 0.3s; }
    .review-img:hover { transform: scale(1.05); }

    .review-form-card { background: white; padding: 3rem; border-radius: 24px; box-shadow: var(--shadow-lg); border: 1px solid var(--border-soft); position: sticky; top: 120px; }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; font-weight: 700; margin-bottom: 0.5rem; color: var(--secondary); font-size: 0.9rem; }
    .form-control { width: 100%; padding: 0.85rem 1.25rem; border-radius: 12px; border: 1.5px solid var(--border); transition: 0.3s; outline: none; font-family: inherit; }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px var(--primary-soft); }
    
    .rating-select { display: flex; gap: 0.5rem; flex-direction: row-reverse; justify-content: flex-end; }
    .rating-select input { display: none; }
    .rating-select label { cursor: pointer; font-size: 1.5rem; color: #e2e8f0; transition: 0.3s; }
    .rating-select input:checked ~ label, .rating-select label:hover, .rating-select label:hover ~ label { color: #ffc107; }

    .image-upload-wrapper { border: 2px dashed var(--border); padding: 1.5rem; border-radius: 16px; text-align: center; cursor: pointer; transition: 0.3s; background: var(--bg-light); }
    .image-upload-wrapper:hover { border-color: var(--primary); background: var(--white); }

    @media (max-width: 992px) {
        .product-hero { padding: 2rem 0; }
        .product-info h1 { font-size: 2rem; }
        .reviews-section { padding: 3rem 0; }
        .reviews-section .container > div { grid-template-columns: 1fr !important; gap: 3rem !important; }
        .review-form-card { position: static; padding: 2rem; }
        
        /* Mobile gallery adjustments */
        .thumbnails {
            gap: 0.75rem;
            padding: 0.5rem 0;
        }
        .thumb {
            width: 60px;
            height: 60px;
            border-radius: 8px;
        }
        
        /* Mobile discount badge adjustments */
        .product-discount-badge {
            top: 0.5rem;
            left: 0.5rem;
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
        }
        .discount-badge {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
    }
    
    @media (max-width: 480px) {
        .main-image {
            border-radius: 16px;
        }
        .thumbnails {
            gap: 0.5rem;
        }
        .thumb {
            width: 50px;
            height: 50px;
            border-radius: 6px;
        }
        
        /* Small mobile discount adjustments */
        .product-discount-badge {
            font-size: 0.7rem;
            padding: 0.3rem 0.6rem;
        }
        .discount-badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            flex-direction: column;
            text-align: center;
            gap: 0.25rem;
        }
        .price-tag {
            font-size: 1.5rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        .price-old {
            font-size: 1rem;
        }
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5); z-index: 1000; display: none;
        align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.3s;
    }
    .modal-overlay.active { display: flex !important; opacity: 1; }
    .modal-card {
        background: white; width: 90%; max-width: 500px;
        padding: 2rem; border-radius: 16px;
        transform: translateY(20px); transition: transform 0.3s;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        position: relative;
    }
    .modal-overlay.active .modal-card { transform: translateY(0); }
    .close-modal {
        position: absolute; top: 1rem; right: 1rem;
        background: none; border: none; font-size: 1.5rem;
        color: #94a3b8; cursor: pointer;
    }
    .close-modal:hover { color: var(--text); }
    
    /* Image Lightbox */
    .image-lightbox {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.9); z-index: 2000; display: none;
        align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.3s;
    }
    .image-lightbox.active { display: flex !important; opacity: 1; }
    .lightbox-content {
        position: relative;
        max-width: 90vw;
        max-height: 90vh;
    }
    .lightbox-image {
        max-width: 100%;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 8px;
    }
    .lightbox-close {
        position: absolute;
        top: -40px;
        right: 0;
        background: none;
        border: none;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        padding: 0.5rem;
    }
    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        font-size: 1.5rem;
        padding: 1rem;
        cursor: pointer;
        border-radius: 50%;
        transition: background 0.3s;
    }
    .lightbox-nav:hover {
        background: rgba(255,255,255,0.3);
    }
    .lightbox-prev {
        left: -60px;
    }
    .lightbox-next {
        right: -60px;
    }
    @media (max-width: 768px) {
        .lightbox-nav {
            font-size: 1.2rem;
            padding: 0.75rem;
        }
        .lightbox-prev {
            left: 10px;
        }
        .lightbox-next {
            right: 10px;
        }
        .lightbox-close {
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<section class="product-hero">
    <div class="container">
        @if(session('success'))
            <div style="background: #ecfdf5; color: #065f46; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid #10b981; display: flex; align-items: center; gap: 0.75rem; font-weight: 600;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="product-grid">
            <!-- Image Gallery -->
            <div class="gallery-container">
                @php
                    $mainImage = $page->hero_image ?? $page->thumbnail ?? '/placeholder.png';
                    $galleryImages = [];
                    
                    // Add main image to gallery
                    if ($mainImage && $mainImage !== '/placeholder.png') {
                        $galleryImages[] = $mainImage;
                    }
                    
                    // Add gallery images
                    if ($page->gallery && is_array($page->gallery)) {
                        foreach ($page->gallery as $img) {
                            if ($img && !in_array($img, $galleryImages)) {
                                $galleryImages[] = $img;
                            }
                        }
                    }
                    
                    // Debug: Show what we have
                    // dd([
                    //     'hero_image' => $page->hero_image,
                    //     'thumbnail' => $page->thumbnail,
                    //     'gallery' => $page->gallery,
                    //     'galleryImages' => $galleryImages
                    // ]);
                @endphp
                
                <div style="position: relative;">
                    <img id="main-view" src="{{ $galleryImages[0] ?? '/placeholder.png' }}" class="main-image" alt="{{ $page->title }}" onclick="openLightbox(0)">
                    
                    @if($page->discount > 0)
                        <div class="product-discount-badge" style="position: absolute; top: 1rem; left: 1rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4); z-index: 10;">
                            -{{ round(($page->discount / ($page->price + $page->discount)) * 100) }}%
                        </div>
                    @endif
                </div>
                
                @if(count($galleryImages) > 0)
                    <div class="thumbnails">
                        @foreach($galleryImages as $index => $image)
                            <img src="{{ $image }}" class="thumb {{ $index === 0 ? 'active' : '' }}" onclick="updatePreview('{{ $image }}', this)" alt="Product image {{ $index + 1 }}">
                        @endforeach
                    </div>
                @else
                    <div style="padding: 1rem; text-align: center; color: #6c757d; font-size: 0.9rem;">
                        <i class="fas fa-image" style="font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i>
                        No additional gallery images available
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <h1>{{ $page->title }}</h1>
                
                @if($page->stock > 0)
                    <div class="stock-status"><i class="fas fa-check"></i> In Stock: {{ $page->stock }} available</div>
                @else
                    <div class="stock-status stock-out"><i class="fas fa-times"></i> Out of Stock</div>
                @endif

                @if($page->discount > 0 && $page->price)
                    <div class="discount-badge" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border-radius: 50px; font-size: 0.85rem; font-weight: 700; margin-bottom: 1rem; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);">
                        <i class="fas fa-tag"></i>
                        {{ round(($page->discount / ($page->price + $page->discount)) * 100) }}% OFF - Save ₹{{ formatIndianPrice($page->discount, 2) }}
                    </div>
                @endif

                @if($page->price)
                    <div class="price-tag">
                        @if($page->discount > 0)
                            <span class="price-old" style="color: #ef4444; text-decoration: line-through; font-size: 1.1rem; margin-right: 0.5rem;">₹{{ formatIndianPrice($page->price + $page->discount, 2) }}</span>
                        @endif
                        <span style="color: var(--primary); font-weight: 700; font-size: 1.3rem;">₹{{ formatIndianPrice($page->price, 2) }}</span>
                    </div>
                @else
                    <div class="price-tag">
                        <span style="color: var(--primary); font-weight: 700; font-size: 1.1rem;">Price on Request</span>
                    </div>
                @endif

                <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 2rem;">
                    {{ $page->meta_description ?? 'This premium product is designed to meet all your needs with high quality and reliability.' }}
                </p>

                <div class="action-buttons">
                    @if(!$page->price)
                        <button onclick="openEnquireModal({{ $page->id }}, '{{ addslashes($page->title) }}')" class="btn-large btn-buy" style="background: var(--primary); justify-content: center; cursor: pointer; width: auto; min-width: 250px;">
                            <i class="fas fa-envelope"></i> Enquire Now
                        </button>
                    @elseif($page->is_enquiry)
                        <button onclick="openEnquireModal({{ $page->id }}, '{{ addslashes($page->title) }}')" class="btn-large btn-buy" style="background: var(--secondary); justify-content: center; cursor: pointer; width: auto; min-width: 250px;">
                            <i class="fas fa-envelope"></i> Enquire Now
                        </button>
                    @else
                        <button onclick="addToCartAjax({{ $page->id }})" class="btn-large btn-cart">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <a href="{{ route('cart.add', $page->id) }}?redirect=checkout" class="btn-large btn-buy">
                            <i class="fas fa-bolt"></i> Buy Now
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<main class="content-area container">
    @if($page->content)
        @php
            if (!function_exists('renderFrontendBlocks')) {
                function renderFrontendBlocks($blocks, $pageId) {
                    foreach($blocks as $block) {
                        if (!is_array($block) || !isset($block['type'])) continue;
                        $settings = $block['settings'] ?? [];
                        $styles = [];
                        if (!empty($settings['bg_color'])) $styles[] = "background-color: {$settings['bg_color']}";
                        if (!empty($settings['text_color'])) $styles[] = "color: {$settings['text_color']}";
                        if (isset($settings['padding_top'])) $styles[] = "padding-top: {$settings['padding_top']}rem";
                        if (isset($settings['padding_bottom'])) $styles[] = "padding-bottom: {$settings['padding_bottom']}rem";
                        if (isset($settings['margin_top'])) $styles[] = "margin-top: {$settings['margin_top']}rem";
                        if (isset($settings['margin_bottom'])) $styles[] = "margin-bottom: {$settings['margin_bottom']}rem";
                        if (isset($settings['font_size'])) $styles[] = "font-size: {$settings['font_size']}px";
                        if (isset($settings['border_radius'])) $styles[] = "border-radius: {$settings['border_radius']}px";
                        
                        $styleAttr = !empty($styles) ? 'style="' . implode('; ', $styles) . '"' : '';
                        
                        echo '<div class="block-wrapper" ' . $styleAttr . '>';
                        
                        if ($block['type'] === 'text') {
                            echo '<div class="block-text">' . ($block['data']['content'] ?? '') . '</div>';
                        } elseif ($block['type'] === 'image') {
                            echo '<div class="block-image"><img src="' . ($block['data']['url'] ?? '') . '" alt="Section Image" style="width: 100%; border-radius: inherit;"></div>';
                        } elseif ($block['type'] === 'button') {
                            echo '<div class="block-button" style="text-align: center; padding: 2rem 0;">
                                    <a href="' . ($block['data']['url'] ?? '#') . '" class="btn-large btn-buy" style="display: inline-flex; width: auto; min-width: 250px; border-radius: inherit;">
                                        ' . ($block['data']['text'] ?? 'Learn More') . '
                                    </a>
                                </div>';
                        } elseif ($block['type'] === 'columns') {
                            echo '<div class="columns-container">';
                            foreach ($block['data']['columns'] ?? [] as $column) {
                                echo '<div class="column">';
                                renderFrontendBlocks($column['blocks'] ?? [], $pageId);
                                echo '</div>';
                            }
                            echo '</div>';
                        } elseif ($block['type'] === 'tabs') {
                            $idx = rand(100, 999);
                            echo '<div class="block-tabs">
                                    <div class="tabs-header">';
                            foreach($block['data']['tabs'] ?? [] as $index => $tab) {
                                $active = $index === 0 ? 'active' : '';
                                echo '<button class="tab-btn ' . $active . '" onclick="switchTab(this, \'tab-' . $pageId . '-' . $idx . '-' . $index . '\')">' . $tab['title'] . '</button>';
                            }
                            echo '</div><div class="tabs-content">';
                            foreach($block['data']['tabs'] ?? [] as $index => $tab) {
                                $active = $index === 0 ? 'active' : '';
                                echo '<div id="tab-' . $pageId . '-' . $idx . '-' . $index . '" class="tab-pane ' . $active . '">' . nl2br(e($tab['content'])) . '</div>';
                            }
                            echo '</div></div>';
                        } elseif ($block['type'] === 'features') {
                            echo '<div class="features-grid">';
                            foreach($block['data']['items'] ?? [] as $feature) {
                                echo '<div class="feature-card">
                                        <div class="feature-title">' . $feature['title'] . '</div>
                                        <p>' . $feature['description'] . '</p>
                                    </div>';
                            }
                            echo '</div>';
                        } elseif ($block['type'] === 'hero_stats') {
                            echo '<div class="hero-stats">
                                    <div class="hero-stats-content">
                                        <h2>' . ($block['data']['title'] ?? '') . '</h2>
                                        <p>' . ($block['data']['description'] ?? '') . '</p>
                                        <div class="stats-grid">';
                            foreach($block['data']['stats'] ?? [] as $stat) {
                                echo '<div class="stat-card">
                                        <span class="stat-value">' . $stat['value'] . '</span>
                                        <span class="stat-label">' . $stat['label'] . '</span>
                                    </div>';
                            }
                            echo '</div></div>
                                    <div class="hero-stats-image">
                                        <img src="' . ($block['data']['image'] ?? '') . '" alt="Hero Stats Image">
                                    </div>
                                </div>';
                        } elseif ($block['type'] === 'timeline') {
                            echo '<div class="timeline">';
                            foreach($block['data']['events'] ?? [] as $event) {
                                echo '<div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-content">
                                            <div class="timeline-year">' . $event['year'] . '</div>
                                            <h3 class="timeline-title">' . $event['title'] . '</h3>
                                            <span class="timeline-badge">' . $event['badge'] . '</span>
                                        </div>
                                    </div>';
                            }
                            echo '</div>';
                        } elseif ($block['type'] === 'split_content') {
                            $reverse = ($block['data']['position'] ?? 'left') === 'right' ? 'reverse' : '';
                            echo '<div class="split-container ' . $reverse . '">
                                    <div class="split-image">
                                        <img src="' . ($block['data']['image'] ?? '') . '" alt="Split Image">
                                    </div>
                                    <div class="split-content">
                                        <h2 class="split-title">' . ($block['data']['title'] ?? '') . '</h2>
                                        <p class="split-desc">' . ($block['data']['description'] ?? '') . '</p>
                                        <div class="split-stats">';
                            foreach($block['data']['stats'] ?? [] as $stat) {
                                echo '<div class="split-stat-item">
                                        <strong>' . $stat['value'] . '</strong>
                                        <span>' . $stat['label'] . '</span>
                                    </div>';
                            }
                            echo '</div></div></div>';
                        }
                        
                        echo '</div>'; // close block-wrapper
                    }
                }
            }
            
            $content = $page->content;
            if (is_string($content)) {
                $decoded = json_decode($content, true);
                $content = is_array($decoded) ? $decoded : [];
            } elseif (!is_array($content)) {
                $content = [];
            }
            // Ensure it's a list of blocks, if it's a single block (assoc array), wrap it
            if (!empty($content) && count(array_filter(array_keys($content), 'is_string')) > 0) {
                 $content = [$content];
            }
            
            renderFrontendBlocks($content, $page->id);
        @endphp
    @endif
</main>

<!-- Reviews Section -->
<section class="reviews-section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 5rem; align-items: start;">
            <div>
                <h2 style="font-size: 2rem; font-weight: 900; color: var(--secondary); margin-bottom: 2.5rem; letter-spacing: -0.02em;">
                    Customer Reviews <span style="color: var(--text-muted); font-weight: 500;">({{ $page->reviews->count() }})</span>
                </h2>

                <div class="reviews-list">
                    @forelse($page->reviews as $review)
                        <div class="review-card">
                            <div class="review-header">
                                <div>
                                    <div class="review-user" style="display: flex; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                                        {{ $review->name }}
                                        <span style="font-size: 0.7rem; color: #059669; background: #ecfdf5; padding: 0.25rem 0.75rem; border-radius: 50px; font-weight: 800; letter-spacing: 0.02em; display: inline-flex; align-items: center; gap: 0.25rem; border: 1px solid #10b98144;">
                                            <i class="fas fa-check-circle" style="font-size: 0.65rem;"></i> VERIFIED PURCHASE
                                        </span>
                                    </div>
                                    <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
                                </div>
                                <div class="star-rating">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="review-comment">
                                {{ $review->comment }}
                            </div>
                            @if(!empty($review->images))
                                <div class="review-images">
                                    @foreach($review->images as $img)
                                        <img src="{{ $img }}" class="review-img" onclick="window.open(this.src)">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div style="text-align: center; padding: 4rem; background: white; border-radius: 24px; border: 1px dashed var(--border);">
                            <i class="fas fa-comment-dots" style="font-size: 3rem; color: var(--border); margin-bottom: 1.5rem;"></i>
                            <h3 style="color: var(--secondary);">No reviews yet</h3>
                            <p style="color: var(--text-muted);">Be the first to review this product!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="review-form-column">
                <div class="review-form-card">
                    <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--secondary); margin-bottom: 0.5rem;">Write a Review</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem;">
                        @if($hasPurchased)
                            Share your experience as a verified customer.
                        @else
                            Share your thoughts with other customers.
                        @endif
                    </p>

                    <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="page_id" value="{{ $page->id }}">
                        
                        @guest
                            <div class="form-group">
                                <label>Your Name</label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                            </div>
                        @endguest

                        <div class="form-group">
                            <label>Overall Rating</label>
                            <div class="rating-select">
                                <input type="radio" name="rating" value="5" id="star5" checked><label for="star5" class="fas fa-star"></label>
                                <input type="radio" name="rating" value="4" id="star4"><label for="star4" class="fas fa-star"></label>
                                <input type="radio" name="rating" value="3" id="star3"><label for="star3" class="fas fa-star"></label>
                                <input type="radio" name="rating" value="2" id="star2"><label for="star2" class="fas fa-star"></label>
                                <input type="radio" name="rating" value="1" id="star1"><label for="star1" class="fas fa-star"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Your Review</label>
                            <textarea name="comment" rows="4" class="form-control" placeholder="What did you think of this product?" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Photos (Optional)</label>
                            <label for="review_images" class="image-upload-wrapper">
                                <i class="fas fa-camera" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 0.5rem; display: block;"></i>
                                <span style="font-size: 0.85rem; font-weight: 700; color: var(--secondary);">Click to upload images</span>
                                <input type="file" id="review_images" name="review_images[]" multiple accept="image/*" style="display: none;" onchange="updateFileLabel(this)">
                            </label>
                            <div id="file-label" style="font-size: 0.8rem; color: var(--primary); margin-top: 0.5rem; font-weight: 600;"></div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem; border-radius: 12px; margin-top: 1rem;">
                            SUBMIT REVIEW <i class="fas fa-paper-plane" style="margin-left: 0.5rem; font-size: 0.8rem;"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<!-- Image Lightbox -->
<div id="imageLightbox" class="image-lightbox" style="display:none;">
    <div class="lightbox-content">
        <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
        <button class="lightbox-nav lightbox-prev" onclick="prevImage()" style="display: none;">&#8249;</button>
        <img id="lightbox-image" src="" class="lightbox-image" alt="Product image">
        <button class="lightbox-nav lightbox-next" onclick="nextImage()" style="display: none;">&#8250;</button>
    </div>
</div>

<!-- Enquiry Modal -->
<div id="enquiryModal" class="modal-overlay" style="display:none;">
    <div class="modal-card">
        <button class="close-modal" onclick="closeEnquiryModal()">&times;</button>
        <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--secondary); margin-bottom: 0.5rem;">Enquire about {{ $page->title }}</h3>
        <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Fill out the form below and we'll get back to you.</p>
        
        <form action="{{ route('contact.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $page->id }}">
            <input type="hidden" name="message" value="I am interested in {{ $page->title }}. Please contact me.">
            
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Phone (Optional)</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" class="form-control" rows="3">I am interested in {{ $page->title }}. Please provide more details.</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem; border-radius: 12px;">
                Send Enquiry
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let galleryImages = @json($galleryImages ?? []);
    let currentImageIndex = 0;

    function updatePreview(url, el) {
        document.getElementById('main-view').src = url;
        document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
        if (el) {
            el.classList.add('active');
        }
        // Update current index for lightbox
        currentImageIndex = galleryImages.indexOf(url);
    }

    // Lightbox functionality
    function openLightbox(index = 0) {
        if (galleryImages.length === 0) return;
        
        currentImageIndex = index;
        const lightbox = document.getElementById('imageLightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        
        lightboxImage.src = galleryImages[currentImageIndex];
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Show/hide navigation buttons
        const prevBtn = document.querySelector('.lightbox-prev');
        const nextBtn = document.querySelector('.lightbox-next');
        
        if (galleryImages.length > 1) {
            prevBtn.style.display = 'block';
            nextBtn.style.display = 'block';
        } else {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        }
    }

    function closeLightbox() {
        const lightbox = document.getElementById('imageLightbox');
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    function prevImage() {
        if (galleryImages.length <= 1) return;
        currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
        document.getElementById('lightbox-image').src = galleryImages[currentImageIndex];
        
        // Update main view and thumbnails
        updatePreview(galleryImages[currentImageIndex], document.querySelector(`.thumb[onclick*="${galleryImages[currentImageIndex]}"]`));
    }

    function nextImage() {
        if (galleryImages.length <= 1) return;
        currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
        document.getElementById('lightbox-image').src = galleryImages[currentImageIndex];
        
        // Update main view and thumbnails
        updatePreview(galleryImages[currentImageIndex], document.querySelector(`.thumb[onclick*="${galleryImages[currentImageIndex]}"]`));
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        const lightbox = document.getElementById('imageLightbox');
        if (!lightbox.classList.contains('active')) return;
        
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowLeft') {
            prevImage();
        } else if (e.key === 'ArrowRight') {
            nextImage();
        }
    });

    // Close lightbox when clicking outside image
    document.getElementById('imageLightbox').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLightbox();
        }
    });

    function switchTab(btn, targetId) {
        const header = btn.closest('.tabs-header');
        const content = header.nextElementSibling;
        header.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        content.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById(targetId).classList.add('active');
    }

    function updateFileLabel(input) {
        const label = document.getElementById('file-label');
        if (input.files.length > 0) {
            label.textContent = `${input.files.length} file(s) selected`;
        } else {
            label.textContent = '';
        }
    }

    // Modal Logic
    const modal = document.getElementById('enquiryModal');
    function openEnquiryModal() {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeEnquiryModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
    // Close on outside click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeEnquiryModal();
    });
</script>
@endpush
