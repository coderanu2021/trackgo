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
            --dark: #0f172a;
            --light: #f8fafc;
            --text-main: #334155;
            --text-muted: #64748b;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--light);
            color: var(--text-main);
            margin: 0;
            line-height: 1.6;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        header {
            background: white;
            padding: 4rem 0;
            border-bottom: 1px solid #e2e8f0;
            text-align: center;
        }
        header h1 {
            font-size: 3rem;
            font-weight: 800;
            margin: 0;
            color: var(--dark);
        }

        .content-area {
            padding: 4rem 0;
        }

        .block {
            margin-bottom: 3rem;
        }

        /* Standard Block Styles */
        .block-text {
            font-size: 1.125rem;
            color: var(--text-main);
        }
        .block-text h2 { color: var(--dark); margin-top: 2rem; }
        
        .block-image img {
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .btn-awesome {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
            transition: all 0.3s ease;
        }
        .btn-awesome:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.4);
        }

        /* Tabs & Features (Reused from project) */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .feature-title { font-weight: 700; margin-bottom: 0.5rem; color: var(--dark); }

        .tabs-header { display: flex; gap: 1rem; margin-bottom: 2rem; border-bottom: 2px solid #e2e8f0; }
        .tab-btn { background: none; border: none; padding: 1rem 1.5rem; font-weight: 700; cursor: pointer; color: var(--text-muted); position: relative; }
        .tab-btn.active { color: var(--primary); }
        .tab-btn.active::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 100%; height: 2px; background: var(--primary); }
        .tab-pane { display: none; }
        .tab-pane.active { display: block; animation: fadeIn 0.4s ease; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        footer {
            padding: 4rem 0;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            color: var(--text-muted);
        }
    </style>
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
</head>
<body>
    <header>
        <div class="container text-center">
            <a href="/" style="text-decoration: none; color: var(--text-muted); font-weight: 600; font-size: 0.9rem; margin-bottom: 1rem; display: block;">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
            <h1>{{ $page->title }}</h1>
        </div>
    </header>

    <main class="content-area container">
        @if($page->content)
            @foreach($page->content as $block)
                <div class="block">
                    @if($block['type'] === 'text')
                        <div class="block-text">
                            {!! $block['data']['content'] ?? '' !!}
                        </div>
                    @elseif($block['type'] === 'image')
                        <div class="block-image">
                            <img src="{{ $block['data']['url'] ?? '' }}" alt="Section Image">
                        </div>
                    @elseif($block['type'] === 'button')
                        <div style="text-align: center;">
                            <a href="{{ $block['data']['url'] ?? '#' }}" class="btn-awesome">
                                {{ $block['data']['text'] ?? 'Learn More' }}
                            </a>
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
                    @elseif($block['type'] === 'tabs')
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
                                    {!! nl2br(e($tab['content'] ?? '')) !!}
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
</body>
</html>
