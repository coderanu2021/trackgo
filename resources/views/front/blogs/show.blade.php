@extends('layouts.front')

@section('title', $blog->title . ' - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<article>
    <!-- Post Header -->
    <header style="background: var(--bg-light); padding: 8rem 0; border-bottom: 1px solid var(--border);">
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
                <img src="{{ $blog->image }}" alt="{{ $blog->title }}" style="width: 100%; height: auto; display: block;">
            </div>
            @endif
        </div>
    </header>

    <!-- Post Content -->
    <div style="padding: 6rem 0;">
        <div class="container" style="max-width: 800px;">
            <div class="blog-content" style="font-size: 1.15rem; line-height: 1.9; color: #374151;">
                {!! $blog->content !!}
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
                        <img src="{{ $rb->image }}" alt="{{ $rb->title }}" style="width: 100%; height: 100%; object-fit: cover;">
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
