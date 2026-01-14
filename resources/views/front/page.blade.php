<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->meta_title ?? $page->title }}</title>
    <meta name="description" content="{{ $page->meta_description }}">
    <meta name="keywords" content="{{ $page->meta_keywords }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: rgba(79, 70, 229, 0.1);
            --dark: #0f172a;
            --light: #f8fafc;
            --text-main: #334155;
            --text-muted: #64748b;
            --border-soft: #e2e8f0;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--light);
            color: var(--text-main);
            margin: 0;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        /* Product Hero Section */
        .product-hero {
            background: white;
            padding: 4rem 0;
            border-bottom: 1px solid var(--border-soft);
        }
        .product-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
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
        }
        .thumbnails {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }
        .thumb {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s;
        }
        .thumb:hover, .thumb.active {
            border-color: var(--primary);
        }

        /* Info Styles */
        .product-info h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0 0 1rem;
            color: var(--dark);
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
            color: var(--text-muted);
            text-decoration: line-through;
            font-weight: 400;
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
            flex: 1;
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
        .btn-cart { background: var(--light); color: var(--dark); border: 1px solid var(--border-soft); }
        .btn-buy { background: var(--primary); color: white; }
        .btn-buy:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3); }

        /* Block Editor Sections */
        .content-area { padding: 4rem 0; }
        .block { margin-bottom: 4rem; }
        .block-text { font-size: 1.125rem; color: var(--text-main); }
        .block-text h2 { color: var(--dark); margin-top: 0; font-size: 2rem; font-weight: 700; }
        
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; }
        .feature-card { background: white; padding: 2rem; border-radius: 20px; border: 1px solid var(--border-soft); transition: all 0.3s; }
        .feature-card:hover { transform: translateY(-5px); border-color: var(--primary); }
        .feature-title { font-weight: 700; font-size: 1.25rem; margin-bottom: 0.75rem; color: var(--dark); }

        footer { padding: 4rem 0; text-align: center; border-top: 1px solid var(--border-soft); color: var(--text-muted); }
    </style>
</head>
<body>
    <nav style="background: white; padding: 1rem 0; border-bottom: 1px solid var(--border-soft);">
        <div class="container">
            <a href="/" style="text-decoration: none; color: var(--text-muted); font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-arrow-left"></i> Back to Catalog
            </a>
        </div>
    </nav>

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
                    <img id="main-view" src="{{ $page->thumbnail ?? ($page->gallery[0] ?? '/placeholder.png') }}" class="main-image" alt="{{ $page->title }}">
                    @if(!empty($page->gallery))
                        <div class="thumbnails">
                            <img src="{{ $page->thumbnail }}" class="thumb active" onclick="updatePreview(this.src, this)">
                            @foreach($page->gallery as $img)
                                <img src="{{ $img }}" class="thumb" onclick="updatePreview(this.src, this)">
                            @endforeach
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

                    <div class="price-tag">
                        @if($page->discount > 0)
                            <span class="price-old">${{ number_format($page->price + $page->discount, 2) }}</span>
                        @endif
                        <span>${{ number_format($page->price, 2) }}</span>
                    </div>

                    <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 2rem;">
                        {{ $page->meta_description ?? 'This premium product is designed to meet all your needs with high quality and reliability.' }}
                    </p>

                    @if($page->price > 0)
                        <div class="action-buttons">
                            <a href="{{ route('cart.add', $page->id) }}" class="btn-large btn-cart">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </a>
                            <a href="{{ route('cart.add', $page->id) }}?redirect=checkout" class="btn-large btn-buy">
                                <i class="fas fa-bolt"></i> Buy Now
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <main class="content-area container">
        @if($page->content)
            @foreach($page->content as $block)
                @php
                    $settings = $block['settings'] ?? [];
                    $styles = [];
                    if (!empty($settings['bg_color'])) $styles[] = "background-color: {$settings['bg_color']}";
                    if (!empty($settings['text_color'])) $styles[] = "color: {$settings['text_color']}";
                    if (isset($settings['padding_top'])) $styles[] = "padding-top: {$settings['padding_top']}rem";
                    if (isset($settings['padding_bottom'])) $styles[] = "padding-bottom: {$settings['padding_bottom']}rem";
                    $styleAttr = !empty($styles) ? 'style="' . implode('; ', $styles) . '"' : '';
                @endphp
                <div class="block" {!! $styleAttr !!}>
                    @if($block['type'] === 'text')
                        <div class="block-text">
                            {!! $block['data']['content'] ?? '' !!}
                        </div>
                    @elseif($block['type'] === 'image')
                        <div class="block-image">
                            <img src="{{ $block['data']['url'] ?? '' }}" alt="Section Image" style="width: 100%; border-radius: 20px;">
                        </div>
                    @elseif($block['type'] === 'features')
                        <div class="features-grid">
                            @foreach($block['data']['items'] ?? [] as $feature)
                                <div class="feature-card">
                                    <div class="feature-title">{{ $feature['title'] }}</div>
                                    <p>{{ $feature['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </main>

    <footer>
        <div class="container">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </footer>

    <script>
        function updatePreview(url, el) {
            document.getElementById('main-view').src = url;
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
        }
    </script>
</body>
</html>
