<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrackGo - Creative Studio</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #ec4899;
            --dark: #0f172a;
            --light: #f8fafc;
        }
        
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--dark);
            color: white;
            margin: 0;
            line-height: 1.6;
        }

        .navbar {
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            width: 100%;
            box-sizing: border-box;
            z-index: 20;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
        }

        .nav-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            margin-left: 2rem;
            font-weight: 600;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: white;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: radial-gradient(circle at 50% 50%, #1e293b 0%, #0f172a 100%);
            padding: 2rem;
            box-sizing: border-box;
        }

        .hero-title {
            font-size: clamp(3rem, 8vw, 6rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, #818cf8, #f472b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            color: #94a3b8;
            max-width: 600px;
            margin: 0 auto 3rem;
        }

        .btn-cta {
            padding: 1rem 2.5rem;
            background: white;
            color: var(--dark);
            border-radius: 50px;
            font-weight: 800;
            text-decoration: none;
            font-size: 1.1rem;
            transition: transform 0.2s, box-shadow 0.2s;
            display: inline-block;
        }
        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(255, 255, 255, 0.2);
        }

        .projects-section {
            padding: 5rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 4rem;
        }

        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }

        .project-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s;
            text-decoration: none;
            color: white;
            display: block;
        }

        .project-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.05);
        }

        .project-image {
            height: 250px;
            width: 100%;
            object-fit: cover;
            background: #1e293b;
        }

        .project-info {
            padding: 2rem;
        }

        .project-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
        }

        .project-meta {
            color: #94a3b8;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ url('/') }}" class="logo">TrackGo.</a>
        <div class="nav-links">
            @auth
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </nav>
    
    <section class="hero-section">
        <div>
            <h1 class="hero-title">Crafted Digital<br>Experiences.</h1>
            <p class="hero-subtitle">We build premium websites with stunning aesthetics and seamless functionality.</p>
            <a href="#work" class="btn-cta">View Our Work</a>
        </div>
    </section>

    <section id="work" class="projects-section">
        <h2 class="section-title">Selected Works</h2>
        
        <div class="projects-grid">
            @forelse($projects as $project)
            <a href="{{ route('projects.show', $project->slug) }}" class="project-card">
                @if($project->hero_image)
                    <img src="{{ $project->hero_image }}" alt="{{ $project->title }}" class="project-image">
                @else
                    <div class="project-image" style="display:flex;align-items:center;justify-content:center;color:#475569;">No Image</div>
                @endif
                <div class="project-info">
                    <h3 class="project-title">{{ $project->title }}</h3>
                    <div class="project-meta">Published Project</div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 4rem; color: #94a3b8; border: 1px dashed rgba(255,255,255,0.1); border-radius: 20px;">
                <h3>No projects published yet.</h3>
                <p>Check back soon for our latest work.</p>
            </div>
            @endforelse
        </div>
    </section>
</body>
</html>
