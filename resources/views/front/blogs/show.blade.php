@extends('layouts.front')

@push('styles')
<style>
    /* Post Builder Styles */
    .block-content img { max-width: 100%; border-radius: 12px; }
    
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
    
    /* Hero Stats Block */
    .hero-stats {
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

    /* Tabs Block */
    .block-tabs { margin-bottom: 2rem; }
    .tabs-header { display: flex; gap: 1rem; border-bottom: 1px solid #e2e8f0; margin-bottom: 1.5rem; }
    .tab-btn { padding: 0.75rem 1.5rem; border: none; background: none; font-weight: 700; color: #64748b; cursor: pointer; transition: 0.3s; border-bottom: 3px solid transparent; }
    .tab-btn.active { color: var(--primary); border-bottom-color: var(--primary); }
    .tab-pane { display: none; }
    .tab-pane.active { display: block; animation: fadeIn 0.5s ease; }

    /* Features Block */
    .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; }
    .feature-card { background: white; padding: 2rem; border-radius: 16px; border: 1px solid #e2e8f0; }
    .feature-title { font-size: 1.25rem; font-weight: 800; margin-bottom: 1rem; color: var(--dark); }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

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
@endpush

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

@section('title', $blog->title . ' - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<article>
    <!-- Post Header -->
    <header style="background: var(--bg-light); padding:10px; border-bottom: 1px solid var(--border);">
        <div class="container" style="max-width: 900px;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 0.5rem 1.25rem; border-radius: 30px; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 2rem;">
                    <i class="fas fa-bookmark"></i> Featured Story
                </div>
                <h1 style="font-size: 3.5rem; font-weight: 800; letter-spacing: -0.04em; line-height: 1.1; margin-bottom: 2rem; color: var(--secondary); font-family: 'Outfit', sans-serif;">
                    {{ $blog->title }}
                </h1>
                <div style="display: flex; align-items: center; justify-content: center; gap: 2rem; color: var(--text-muted); font-weight: 600; font-size: 0.95rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 32px; height: 32px; background: var(--secondary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">
                            {{ strtoupper(substr($blog->user->name ?? 'A', 0, 1)) }}
                        </div>
                        {{ $blog->user->name ?? 'Administrator' }}
                    </div>
                    <div>•</div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <i class="far fa-calendar"></i> {{ $blog->created_at->format('M d, Y') }}
                    </div>
                    <div>•</div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <i class="far fa-clock"></i> 5 min read
                    </div>
                </div>
            </div>

            @if($blog->image)
            <div style="border-radius: 20px; overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.12); border: 1px solid var(--border);">
                <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" style="width: 100%; height: auto; display: block;">
            </div>
            @endif
        </div>
    </header>

    <!-- Post Content -->
    <div style="padding: 6rem 0;">
        <div class="container" style="max-width: 800px;">
            <div class="blog-content" style="font-size: 1.15rem; line-height: 1.9; color: #374151;">
                @if(is_array($blog->content))
                    @php
                        if (!function_exists('renderBlogBlocks')) {
                            function renderBlogBlocks($blocks, $blogId) {
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
                                        echo '<div class="block block-text">' . ($block['data']['content'] ?? '') . '</div>';
                                    } elseif ($block['type'] === 'image') {
                                        echo '<div class="block block-image" style="margin: 2rem 0;"><img src="' . ($block['data']['url'] ?? '') . '" alt="' . ($block['data']['alt'] ?? 'Blog Image') . '" style="width: 100%; border-radius: inherit;"></div>';
                                    } elseif ($block['type'] === 'button') {
                                        echo '<div class="block block-button" style="text-align: center; margin: 2rem 0;">
                                                <a href="' . ($block['data']['url'] ?? '#') . '" class="btn btn-primary" style="padding: 1rem 2.5rem; border-radius: 50px;">
                                                    ' . ($block['data']['text'] ?? 'Click Here') . '
                                                </a>
                                            </div>';
                                    } elseif ($block['type'] === 'columns') {
                                        echo '<div class="columns-container">';
                                        foreach ($block['data']['columns'] ?? [] as $column) {
                                            echo '<div class="column">';
                                            renderBlogBlocks($column['blocks'] ?? [], $blogId);
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                    } elseif ($block['type'] === 'tabs') {
                                        $idx = rand(100, 999);
                                        echo '<div class="block block-tabs">
                                                <div class="tabs-header">';
                                        foreach($block['data']['tabs'] ?? [] as $index => $tab) {
                                            $active = $index === 0 ? 'active' : '';
                                            echo '<button class="tab-btn ' . $active . '" onclick="switchTab(this, \'tab-' . $blogId . '-' . $idx . '-' . $index . '\')">' . $tab['title'] . '</button>';
                                        }
                                        echo '</div><div class="tabs-content">';
                                        foreach($block['data']['tabs'] ?? [] as $index => $tab) {
                                            $active = $index === 0 ? 'active' : '';
                                            echo '<div id="tab-' . $blogId . '-' . $idx . '-' . $index . '" class="tab-pane ' . $active . '">' . nl2br(e($tab['content'])) . '</div>';
                                        }
                                        echo '</div></div>';
                                    } elseif ($block['type'] === 'features') {
                                        echo '<div class="block" style="margin: 3rem 0;">
                                                <div class="features-grid">';
                                        foreach($block['data']['items'] ?? [] as $feature) {
                                            echo '<div class="feature-card">
                                                    <div class="feature-title">' . ($feature['title'] ?? 'Feature Title') . '</div>
                                                    <p style="font-size: 0.95rem; color: #64748b;">' . ($feature['description'] ?? '') . '</p>
                                                </div>';
                                        }
                                        echo '</div></div>';
                                    } elseif ($block['type'] === 'hero_stats') {
                                        echo '<div class="hero-stats" style="margin: 4rem 0;">
                                                <div class="hero-stats-content">
                                                    <h2 style="font-size: 2rem;">' . ($block['data']['title'] ?? '') . '</h2>
                                                    <p style="font-size: 1rem;">' . ($block['data']['description'] ?? '') . '</p>
                                                    <div class="stats-grid">';
                                        foreach($block['data']['stats'] ?? [] as $stat) {
                                            echo '<div class="stat-card">
                                                    <span class="stat-value" style="font-size: 1.5rem;">' . $stat['value'] . '</span>
                                                    <span class="stat-label" style="font-size: 0.75rem;">' . $stat['label'] . '</span>
                                                </div>';
                                        }
                                        echo '</div></div>
                                                <div class="hero-stats-image">
                                                    <img src="' . ($block['data']['image'] ?? '') . '" alt="Hero Stats Image">
                                                </div>
                                            </div>';
                                    } elseif ($block['type'] === 'timeline') {
                                        echo '<div class="timeline-section" style="margin: 4rem 0;">
                                                <div class="timeline">';
                                        foreach($block['data']['events'] ?? [] as $event) {
                                            echo '<div class="timeline-item">
                                                    <div class="timeline-dot"></div>
                                                    <div class="timeline-content">
                                                        <div class="timeline-year">' . $event['year'] . '</div>
                                                        <h3 class="timeline-title" style="font-size: 1.1rem;">' . $event['title'] . '</h3>
                                                        <span class="timeline-badge">' . $event['badge'] . '</span>
                                                    </div>
                                                </div>';
                                        }
                                        echo '</div></div>';
                                    } elseif ($block['type'] === 'split_content') {
                                        $reverse = ($block['data']['position'] ?? 'left') === 'right' ? 'reverse' : '';
                                        echo '<div class="split-section" style="margin: 4rem 0;">
                                                <div class="split-container ' . $reverse . '" style="gap: 2rem;">
                                                    <div class="split-image">
                                                        <img src="' . ($block['data']['image'] ?? '') . '" alt="Split Image">
                                                    </div>
                                                    <div class="split-content">
                                                        <h2 class="split-title" style="font-size: 1.75rem;">' . ($block['data']['title'] ?? '') . '</h2>
                                                        <p class="split-desc" style="font-size: 1rem;">' . ($block['data']['description'] ?? '') . '</p>
                                                        <div class="split-stats">';
                                        foreach($block['data']['stats'] ?? [] as $stat) {
                                            echo '<div class="split-stat-item">
                                                    <strong style="font-size: 1.25rem;">' . $stat['value'] . '</strong>
                                                    <span style="font-size: 0.8rem;">' . $stat['label'] . '</span>
                                                </div>';
                                        }
                                        echo '</div></div></div></div>';
                                    }
                                    
                                    echo '</div>'; // close block-wrapper
                                }
                            }
                        }
                        
                        renderBlogBlocks($blog->content, $blog->id);
                    @endphp
                @else
                    {!! $blog->content !!}
                @endif
            </div>

            <!-- Share and Social -->
            <div style="margin-top: 5rem; padding-top: 3rem; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <span style="font-weight: 700; color: var(--secondary); font-size: 0.9rem;">SHARE THIS STORY</span>
                    <div style="display: flex; gap: 1rem;">
                        <a href="#" style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); transition: 0.3s;" onmouseover="this.style.background='var(--primary)'; this.style.color='white'; this.style.borderColor='var(--primary)';" onmouseout="this.style.background='transparent'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border)';"><i class="fab fa-twitter"></i></a>
                        <a href="#" style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); transition: 0.3s;" onmouseover="this.style.background='#1877f2'; this.style.color='white'; this.style.borderColor='#1877f2';" onmouseout="this.style.background='transparent'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border)';"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); transition: 0.3s;" onmouseover="this.style.background='#0077b5'; this.style.color='white'; this.style.borderColor='#0077b5';" onmouseout="this.style.background='transparent'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border)';"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <a href="{{ route('blogs.index') }}" style="font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem;">
                    BACK TO STORIES <i class="fas fa-arrow-left" style="font-size: 0.75rem; order: -1;"></i>
                </a>
            </div>
        </div>
    </div>
</article>

<!-- Recent Stories -->
<section style="background: var(--bg-light); padding: 8rem 0; border-top: 1px solid var(--border);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 4rem;">
            <div>
                <h2 style="font-size: 2.5rem; font-weight: 800; color: var(--secondary); font-family: 'Outfit', sans-serif;">Continue Reading</h2>
                <p style="color: var(--text-muted); font-size: 1.1rem; margin-top: 1rem;">Explore more interesting stories from the blog.</p>
            </div>
            <a href="{{ route('blogs.index') }}" class="btn" style="background: white; border: 1px solid var(--border); color: var(--secondary);">View All Articles</a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 3rem;">
            @foreach($recent_blogs as $rb)
            <article style="background: white; border-radius: 16px; overflow: hidden; border: 1px solid var(--border); transition: 0.4s;" 
                     onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.05)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                @if($rb->image)
                    <div style="height: 200px; overflow: hidden;">
                        <img src="{{ $rb->image_url }}" alt="{{ $rb->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                @endif
                <div style="padding: 2.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.25rem; color: var(--secondary); line-height: 1.4;">
                        <a href="{{ route('blogs.show', $rb->slug) }}">{{ $rb->title }}</a>
                    </h3>
                    <a href="{{ route('blogs.show', $rb->slug) }}" style="font-weight: 700; color: var(--secondary); display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem;">
                        READ ARTICLE <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
