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
        
        /* Hero */
        .hero {
            position: relative;
            height: 70vh;
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
        }
        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(2px);
        }
        .hero-content {
            position: relative;
            z-index: 10;
        }
        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.05em;
            text-transform: uppercase;
        }

        /* Content Blocks */
        .block {
            padding: 4rem 0;
        }
        
        .block-text {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1.25rem;
            color: #334155;
        }
        .block-text ul, .block-text ol {
            margin-left: 1.5rem;
        }

        .block-image img {
            width: 100%;
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .block-button {
            text-align: center;
        }
        .btn-awesome {
            display: inline-block;
            padding: 1rem 2.5rem;
            background-color: var(--primary);
            color: white;
            font-weight: 700;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.4);
        }
        .btn-awesome:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px rgba(79, 70, 229, 0.5);
        }

        .block-table {
            overflow-x: auto;
        }
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .custom-table td, .custom-table th {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        .custom-table tr:last-child td {
            border-bottom: none;
        }
        .custom-table tr:first-child {
            background-color: #f1f5f9;
            font-weight: 600;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        /* Tabs */
        .tabs-header {
            display: flex;
            gap: 1rem;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 1.5rem;
        }
        .tab-btn {
            background: none;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.2s;
        }
        .tab-btn:hover {
            color: var(--primary);
        }
        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }
        .tab-pane {
            display: none;
            animation: fadeIn 0.3s ease;
        }
        .tab-pane.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
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

    <main class="container">
        @if($page->content)
            @foreach($page->content as $block)
                <div class="block">
                    <!-- Text Block -->
                    @if($block['type'] === 'text')
                        <div class="block-text">
                            {!! $block['data']['content'] ?? '' !!}
                        </div>
                    
                    <!-- Image Block -->
                    @elseif($block['type'] === 'image')
                        <div class="block-image">
                            <img src="{{ $block['data']['url'] ?? '' }}" alt="Project Image">
                        </div>
                    
                    <!-- Button Block -->
                    @elseif($block['type'] === 'button')
                        <div class="block-button">
                            <a href="{{ $block['data']['url'] ?? '#' }}" class="btn-awesome">
                                {{ $block['data']['text'] ?? 'Click Here' }}
                            </a>
                        </div>

                    <!-- Table Block -->
                    @elseif($block['type'] === 'table')
                        <div class="block-table">
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
                        <div class="block-tabs">
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

                    <!-- Features Block -->
                    @elseif($block['type'] === 'features')
                        <div class="features-grid">
                            <div class="feature-card">
                                <div class="feature-title">{{ $block['data']['title1'] ?? 'Feature 1' }}</div>
                                <p>Lorem ipsum dolor sit amet.</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-title">{{ $block['data']['title2'] ?? 'Feature 2' }}</div>
                                <p>Consectetur adipiscing elit.</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-title">{{ $block['data']['title3'] ?? 'Feature 3' }}</div>
                                <p>Sed do eiusmod tempor incididunt.</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </main>
</body>
</html>
