@extends('layouts.front')

@section('title', 'Insights & Articles - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<div style="background: var(--bg-light); padding: 6rem 0; border-bottom: 1px solid var(--border);">
    <div class="container" style="text-align: center;">
        <h1 style="font-size: 3.5rem; font-weight: 800; letter-spacing: -0.04em; margin-bottom: 1rem; color: var(--secondary);">Insights & Articles</h1>
        <p style="color: var(--text-muted); font-size: 1.25rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
            Explore our curated selection of articles on design, technology, and the future of creative platforms.
        </p>
    </div>
</div>

<div class="container" style="padding: 6rem 0;">
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 3rem;">
        @forelse($blogs as $blog)
        <article style="background: white; border-radius: 16px; overflow: hidden; border: 1px solid var(--border); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); height: 100%; display: flex; flex-direction: column;" 
                 onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.08)'; this.style.borderColor='var(--primary)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='var(--border)';"
                 onclick="window.location.href='{{ route('blogs.show', $blog->slug) }}'" style="cursor: pointer;">
            @if($blog->image)
                <div style="height: 240px; overflow: hidden; position: relative;">
                    <img src="{{ $blog->image }}" alt="{{ $blog->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: 0.6s;">
                    <div style="position: absolute; top: 1.5rem; left: 1.5rem; background: var(--primary); color: white; padding: 0.5rem 1rem; border-radius: 30px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                        Article
                    </div>
                </div>
            @endif
            <div style="padding: 2.5rem; flex: 1; display: flex; flex-direction: column;">
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="far fa-calendar"></i> {{ $blog->created_at->format('M d, Y') }}
                </div>
                <h3 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 1.25rem; color: var(--secondary); line-height: 1.3; font-family: 'Outfit', sans-serif;">
                    <a href="{{ route('blogs.show', $blog->slug) }}" style="color: inherit;">{{ $blog->title }}</a>
                </h3>
                <p style="color: var(--text); font-size: 1rem; line-height: 1.7; margin-bottom: 2rem; flex: 1;">
                    {{ Str::limit(strip_tags($blog->content), 140) }}
                </p>
                <div style="padding-top: 1.5rem; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
                    <span style="font-weight: 700; color: var(--secondary); font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;">
                        READ FULL STORY <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                    </span>
                    <span style="font-size: 0.85rem; color: var(--text-muted);"><i class="far fa-clock"></i> 5 min read</span>
                </div>
            </div>
        </article>
        @empty
        <div style="grid-column: 1/-1; text-align:center; padding: 4rem;">
            <i class="fas fa-newspaper" style="font-size: 4rem; color: var(--border); margin-bottom: 2rem;"></i>
            <h3>No articles found yet.</h3>
            <p>Check back later for fresh insights.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="margin-top: 5rem; display: flex; justify-content: center;">
        {{ $blogs->links() }}
    </div>
</div>
@endsection
