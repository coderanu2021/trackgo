@extends('layouts.front')

@section('title', $page->title)

@push('styles')
<style>
    /* Banner Section - 250px height */
    .page-banner {
        background-size: cover;
        background-position: center;
        height: 250px;
        position: relative;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .page-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.4);
    }
    .banner-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }
    .banner-content h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.02em;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    /* Hero Stats Block */
    .hero-stats {
        background: white;
        padding: 4rem 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }
    .hero-stats-content h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }
    .hero-stats-content p {
        font-size: 1.25rem;
        color: #64748b;
        margin-bottom: 2rem;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    .stat-card {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 12px;
        border-left: 4px solid var(--primary);
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--secondary);
        display: block;
    }
    .stat-label {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .hero-stats-image img {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    /* Timeline Block */
    .timeline-section {
        padding: 4rem 2rem;
        background: #f8fafc;
    }
    .timeline {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        width: 4px;
        height: 100%;
        background: #e2e8f0;
        transform: translateX(-50%);
    }
    .timeline-item {
        padding: 1rem 0;
        position: relative;
        width: 50%;
        box-sizing: border-box;
    }
    .timeline-item:nth-child(odd) {
        left: 0;
        padding-right: 3rem;
        text-align: right;
    }
    .timeline-item:nth-child(even) {
        left: 50%;
        padding-left: 3rem;
    }
    .timeline-dot {
        position: absolute;
        width: 20px;
        height: 20px;
        background: var(--primary);
        border-radius: 50%;
        top: 1.5rem;
        z-index: 10;
    }
    .timeline-item:nth-child(odd) .timeline-dot {
        right: -12px;
    }
    .timeline-item:nth-child(even) .timeline-dot {
        left: -12px;
    }
    .timeline-content {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .timeline-year {
        font-size: 0.9rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    .timeline-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0 0 0.5rem;
    }
    .timeline-badge {
        display: inline-block;
        background: #e0e7ff;
        color: var(--primary);
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Split Content Block */
    .split-section {
        padding: 4rem 2rem;
        background: white;
    }
    .split-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 4rem;
    }
    .split-container.reverse {
        flex-direction: row-reverse;
    }
    .split-content {
        flex: 1;
    }
    .split-image {
        flex: 1;
    }
    .split-image img {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .split-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }
    .split-desc {
        font-size: 1.1rem;
        color: #64748b;
        margin-bottom: 2rem;
    }
    .split-stats {
        display: flex;
        gap: 2rem;
    }
    .split-stat-item strong {
        display: block;
        font-size: 1.5rem;
        color: var(--primary);
    }
    .split-stat-item span {
        font-size: 0.9rem;
        color: #64748b;
    }

    /* Purchase Box */
    .purchase-section {
        padding: 4rem 1.5rem;
        background: white;
        border-top: 1px solid #e2e8f0;
    }
    .purchase-box {
        max-width: 600px;
        margin: 0 auto;
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 24px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border: 1px solid #f1f5f9;
        text-align: center;
    }
    .price-tag {
        font-size: 3rem;
        font-weight: 800;
        color: var(--secondary);
        margin-bottom: 0.5rem;
        display: block;
    }
    .price-label {
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 0.875rem;
        margin-bottom: 2rem;
        display: block;
    }
    .purchase-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .btn-purchase {
        padding: 1rem 1.5rem;
        border-radius: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        border: none;
        cursor: pointer;
    }
    .btn-cart {
        background: #f1f5f9;
        color: var(--secondary);
    }
    .btn-cart:hover {
        background: #e2e8f0;
    }
    .btn-buynow {
        background: var(--primary);
        color: white;
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }
    .btn-buynow:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.4);
    }

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
    
    /* Text Block Styling */
    .block-text {
        background: white;
        padding: 3rem;
        margin: 2rem auto;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        max-width: 900px; /* Reduced from 1200px to 900px */
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .block-text:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }
    
    .block-text::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary) 0%, #ff8c42 100%);
    }
    
    .block-text h2 {
        color: var(--secondary);
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid var(--primary);
        display: inline-block;
        background: linear-gradient(135deg, var(--secondary) 0%, #4a5568 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .block-text h3 {
        color: var(--secondary);
        font-size: 1.75rem;
        font-weight: 700;
        margin: 2rem 0 1rem 0;
        padding-left: 1rem;
        border-left: 4px solid var(--primary);
    }
    
    .block-text p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #4a5568;
        margin-bottom: 1.5rem;
        text-align: justify;
    }
    
    .block-text ul {
        margin: 1.5rem 0;
        padding-left: 0;
        list-style: none;
    }
    
    .block-text ul li {
        background: #f8fafc;
        margin: 0.75rem 0;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        border-left: 4px solid var(--primary);
        font-size: 1rem;
        color: #2d3748;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .block-text ul li:hover {
        background: #edf2f7;
        transform: translateX(5px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .block-text ul li:before {
        content: "✓";
        color: var(--primary);
        font-weight: bold;
        margin-right: 0.75rem;
        font-size: 1.1rem;
    }

    /* Container improvements - Only for page template */
    .page-container {
        max-width: 1000px; /* Reduced from 1400px */
        margin: 0 auto;
        padding: 0 2rem;
    }
    
    /* Main content area */
    main {
        background: #f8fafc;
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    /* Block wrapper improvements */
    .block-wrapper {
        margin-bottom: 1rem;
    }
    
    /* Image block styling */
    .block-image {
        background: white;
        padding: 2rem;
        margin: 2rem auto;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        max-width: 900px; /* Reduced from 1200px */
        text-align: center;
    }
    
    .block-image img {
        border-radius: 12px;
        box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    /* Button block styling */
    .block-button {
        background: white;
        padding: 2rem;
        margin: 2rem auto;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        max-width: 900px; /* Reduced from 1200px */
    }
    
    @media (max-width: 768px) {
        .columns-container {
            flex-direction: column;
        }
        .block-text {
            padding: 2rem;
            margin: 1rem;
        }
        .block-text h2 {
            font-size: 2rem;
        }
        .block-text h3 {
            font-size: 1.5rem;
        }
        .page-container {
            padding: 0 1rem;
        }
    }

    /* Tabs Block */
    .tabs-header { display: flex; gap: 1rem; border-bottom: 1px solid #e2e8f0; margin-bottom: 1.5rem; }
    .tab-btn { padding: 0.75rem 1.5rem; border: none; background: none; font-weight: 700; color: #64748b; cursor: pointer; transition: 0.3s; border-bottom: 3px solid transparent; }
    .tab-btn.active { color: var(--primary); border-bottom-color: var(--primary); }
    .tab-pane { display: none; }
    .tab-pane.active { display: block; }

    @media (max-width: 768px) {
        .page-banner {
            height: 200px;
        }
        .banner-content h1 {
            font-size: 2rem;
        }
        .hero-stats, .split-container {
            grid-template-columns: 1fr;
            flex-direction: column !important;
            gap: 2rem;
        }
        .timeline::before {
            left: 20px;
        }
        .timeline-item {
            width: 100%;
            left: 0 !important;
            padding-left: 3rem !important;
            padding-right: 0 !important;
            text-align: left !important;
        }
        .timeline-item:nth-child(odd) .timeline-dot,
        .timeline-item:nth-child(even) .timeline-dot {
            left: 10px;
            right: auto;
        }
    }
</style>
@endpush

@section('content')
    @if($page->thumbnail)
    @php
        $imageUrl = Str::startsWith($page->thumbnail, ['http://', 'https://']) ? $page->thumbnail : asset($page->thumbnail);
    @endphp
    <div class="page-banner" style="background-image: url('{{ $imageUrl }}');">
        <div class="banner-content">
            <h1>{{ $page->title }}</h1>
        </div>
    </div>
    @else
    <div class="page-banner" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);">
        <div class="banner-content">
            <h1>{{ $page->title }}</h1>
        </div>
    </div>
    @endif

    <main style="background: #f8fafc; min-height: 100vh; padding: 2rem 0;">
        @if(session('success'))
            <div class="container" style="margin-top: 2rem;">
                <div style="background: #ecfdf5; color: #065f46; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid #10b981; display: flex; align-items: center; gap: 0.75rem; font-weight: 600;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            </div>
        @endif

        @if($page->content)
            @php
                if (!function_exists('renderProjectBlocks')) {
                    function renderProjectBlocks($blocks, $pageId) {
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
                                echo '<div class="block block-text page-container">' . ($block['data']['content'] ?? $block['content'] ?? '') . '</div>';
                            } elseif ($block['type'] === 'image') {
                                echo '<div class="block block-image page-container"><img src="' . ($block['data']['url'] ?? $block['url'] ?? '') . '" alt="Project Image" style="width: 100%; border-radius: inherit;"></div>';
                            } elseif ($block['type'] === 'button') {
                                echo '<div class="block block-button page-container" style="text-align: center;">
                                        <a href="' . ($block['data']['url'] ?? $block['url'] ?? '#') . '" class="btn-purchase btn-buynow" style="display: inline-flex; width: auto; min-width: 250px; border-radius: inherit;">
                                            ' . ($block['data']['text'] ?? $block['text'] ?? 'Click Here') . '
                                        </a>
                                    </div>';
                            } elseif ($block['type'] === 'columns') {
                                echo '<div class="columns-container page-container">';
                                foreach ($block['data']['columns'] ?? [] as $column) {
                                    echo '<div class="column">';
                                    renderProjectBlocks($column['blocks'] ?? [], $pageId);
                                    echo '</div>';
                                }
                                echo '</div>';
                            } elseif ($block['type'] === 'tabs') {
                                $idx = rand(100, 999);
                                echo '<div class="block block-tabs page-container">
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
                                echo '<div class="block page-container">
                                        <div class="features-grid">';
                                foreach($block['data']['items'] ?? [] as $feature) {
                                    echo '<div class="feature-card">
                                            <div class="feature-title">' . ($feature['title'] ?? 'Feature Title') . '</div>
                                            <p>' . ($feature['description'] ?? '') . '</p>
                                        </div>';
                                }
                                echo '</div></div>';
                            } elseif ($block['type'] === 'hero_stats') {
                                echo '<div class="hero-stats page-container">
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
                                echo '<div class="timeline-section page-container">
                                        <div class="timeline">';
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
                                echo '</div></div>';
                            } elseif ($block['type'] === 'split_content') {
                                $reverse = ($block['data']['position'] ?? 'left') === 'right' ? 'reverse' : '';
                                echo '<div class="split-section page-container">
                                        <div class="split-container ' . $reverse . '">
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
                                echo '</div></div></div></div>';
                            }
                            
                            echo '</div>'; // close block-wrapper
                        }
                    }
                }
                
                renderProjectBlocks($page->content, $page->id);
            @endphp
        @endif
    </main>
@endsection

@push('scripts')
<script>
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
