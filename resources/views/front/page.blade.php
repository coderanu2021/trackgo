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
        @php
            if (!function_exists('renderFrontendBlocks')) {
                function renderFrontendBlocks($blocks, $pageId) {
                    foreach($blocks as $block) {
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
            
            renderFrontendBlocks($page->content, $page->id);
        @endphp
    @endif
</main>
@endsection

@push('scripts')
<script>
    function updatePreview(url, el) {
        document.getElementById('main-view').src = url;
        document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }

    function switchTab(btn, targetId) {
        const header = btn.closest('.tabs-header');
        const content = header.nextElementSibling;
        header.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        content.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById(targetId).classList.add('active');
    }
</script>
@endpush
