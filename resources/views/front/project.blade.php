<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --dark: #0f172a;
            --light: #f8fafc;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            margin: 0;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
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
            color: var(--dark);
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
            color: var(--dark);
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
            color: var(--dark);
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

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            border: 1px solid #10b981;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
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
    <script>
        function switchTab(btn, targetId) {
            // Find parent headers and content container relative to this block
            const header = btn.closest('.tabs-header');
            const content = header.nextElementSibling;
            
            // Remove active class from all buttons and panes in this block
            header.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            content.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            
            // Activate clicked button and target pane
            btn.classList.add('active');
            document.getElementById(targetId).classList.add('active');
        }
    </script>
</head>
<body>
    @if($page->hero_image)
    <div class="hero" style="background-image: url('{{ $page->hero_image }}');">
        <div class="hero-content container">
            <h1>{{ $page->title }}</h1>
        </div>
    </div>
    @else
    <div class="hero" style="background: linear-gradient(135deg, #4f46e5 0%, #0f172a 100%);">
        <div class="hero-content container">
            <h1>{{ $page->title }}</h1>
        </div>
    </div>
    @endif

    <main>
        @if(session('success'))
            <div class="container" style="margin-top: 2rem;">
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            </div>
        @endif

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
                <div {!! $styleAttr !!}> <!-- Wrapper for spacing control if needed -->
                    
                    <!-- Text Block -->
                    @if($block['type'] === 'text')
                        <div class="block block-text">
                            {!! $block['data']['content'] ?? '' !!}
                        </div>
                    
                    <!-- Image Block -->
                    @elseif($block['type'] === 'image')
                        <div class="block block-image container">
                            <img src="{{ $block['data']['url'] ?? '' }}" alt="Project Image">
                        </div>
                    
                    <!-- Button Block -->
                    @elseif($block['type'] === 'button')
                        <div class="block block-button">
                            <a href="{{ $block['data']['url'] ?? '#' }}" class="btn-awesome">
                                {{ $block['data']['text'] ?? 'Click Here' }}
                            </a>
                        </div>

                    <!-- Table Block -->
                    @elseif($block['type'] === 'table')
                        <div class="block block-table container">
                            <table class="custom-table">
                                @foreach($block['data']['rows'] ?? [] as $row)
                                <tr>
                                    @foreach($row as $cell)
                                    <td>{{ $cell }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </table>
                        </div>

                    <!-- Tabs Block -->
                    @elseif($block['type'] === 'tabs')
                        <div class="block block-tabs container">
                            <div class="tabs-header">
                                @foreach($block['data']['tabs'] ?? [] as $index => $tab)
                                    <button class="tab-btn {{ $index === 0 ? 'active' : '' }}" onclick="switchTab(this, 'tab-{{ $loop->parent->index }}-{{ $index }}')">
                                        {{ $tab['title'] }}
                                    </button>
                                @endforeach
                            </div>
                            <div class="tabs-content">
                                @foreach($block['data']['tabs'] ?? [] as $index => $tab)
                                    <div id="tab-{{ $loop->parent->index }}-{{ $index }}" class="tab-pane {{ $index === 0 ? 'active' : '' }}">
                                        {!! nl2br(e($tab['content'])) !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    <!-- Features Block (Refactored) -->
                    @elseif($block['type'] === 'features')
                        <div class="block container">
                            <div class="features-grid">
                                @foreach($block['data']['items'] ?? [] as $feature)
                                <div class="feature-card">
                                    <div class="feature-title">{{ $feature['title'] ?? 'Feature Title' }}</div>
                                    <p>{{ $feature['description'] ?? '' }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    <!-- Hero Stats Block -->
                    @elseif($block['type'] === 'hero_stats')
                        <div class="hero-stats container">
                            <div class="hero-stats-content">
                                <h2>{{ $block['data']['title'] ?? '' }}</h2>
                                <p>{{ $block['data']['description'] ?? '' }}</p>
                                <div class="stats-grid">
                                    @foreach($block['data']['stats'] ?? [] as $stat)
                                    <div class="stat-card">
                                        <span class="stat-value">{{ $stat['value'] }}</span>
                                        <span class="stat-label">{{ $stat['label'] }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="hero-stats-image">
                                <img src="{{ $block['data']['image'] ?? '' }}" alt="Hero Stats Image">
                            </div>
                        </div>

                    <!-- Timeline Block -->
                    @elseif($block['type'] === 'timeline')
                        <div class="timeline-section">
                            <div class="timeline">
                                @foreach($block['data']['events'] ?? [] as $event)
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-year">{{ $event['year'] }}</div>
                                        <h3 class="timeline-title">{{ $event['title'] }}</h3>
                                        <span class="timeline-badge">{{ $event['badge'] }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    <!-- Split Content Block -->
                    @elseif($block['type'] === 'split_content')
                        <div class="split-section">
                            <div class="split-container {{ ($block['data']['position'] ?? 'left') === 'right' ? 'reverse' : '' }}">
                                <div class="split-image">
                                    <img src="{{ $block['data']['image'] ?? '' }}" alt="Split Image">
                                </div>
                                <div class="split-content">
                                    <h2 class="split-title">{{ $block['data']['title'] ?? '' }}</h2>
                                    <p class="split-desc">{{ $block['data']['description'] ?? '' }}</p>
                                    <div class="split-stats">
                                        @foreach($block['data']['stats'] ?? [] as $stat)
                                        <div class="split-stat-item">
                                            <strong>{{ $stat['value'] }}</strong>
                                            <span>{{ $stat['label'] }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif

    </main>
</body>
</html>
