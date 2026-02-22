@extends('layouts.front')

@section('title', 'Gallery - ' . ($settings['site_name'] ?? 'TrackGo'))

@push('styles')
<style>
    .gallery-hero {
        text-align: center;
        padding: 4rem 0 5rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        color: white;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }
    .gallery-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .gallery-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .gallery-container {
        padding: 2rem 0 4rem;
        background: #f8f9fa;
        min-height: 100vh;
    }

    .gallery-filters {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 3rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 0.75rem 1.5rem;
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 50px;
        color: #6c757d;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .filter-btn:hover, .filter-btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(243, 112, 33, 0.3);
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }

    .gallery-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .gallery-image {
        width: 100%;
        aspect-ratio: 4/3;
        object-fit: cover;
        display: block;
    }

    .gallery-info {
        padding: 1.5rem;
    }

    .gallery-category {
        font-size: 0.75rem;
        color: var(--primary);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .gallery-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .gallery-description {
        font-size: 0.9rem;
        color: #6c757d;
        line-height: 1.5;
    }

    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .lightbox.active {
        display: flex;
    }

    .lightbox-content {
        max-width: 90%;
        max-height: 90%;
        position: relative;
    }

    .lightbox-image {
        max-width: 100%;
        max-height: 90vh;
        object-fit: contain;
    }

    .lightbox-close {
        position: absolute;
        top: -40px;
        right: 0;
        background: none;
        border: none;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        padding: 0.5rem;
    }

    .lightbox-info {
        position: absolute;
        bottom: -60px;
        left: 0;
        right: 0;
        color: white;
        text-align: center;
    }

    @media (max-width: 768px) {
        .gallery-hero h1 {
            font-size: 2rem;
        }
        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="gallery-hero">
    <div class="container">
        <h1>Our Gallery</h1>
        <p>Explore our collection of amazing images and projects</p>
    </div>
</div>

<div class="gallery-container">
    <div class="container">
        <!-- Category Filters -->
        <div class="gallery-filters">
            <a href="{{ route('gallery') }}" class="filter-btn {{ !request('category') ? 'active' : '' }}">
                All Images
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('gallery', ['category' => $cat->slug]) }}" class="filter-btn {{ request('category') == $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <!-- Gallery Grid -->
        @if($galleries->count() > 0)
            <div class="gallery-grid">
                @foreach($galleries as $gallery)
                    <div class="gallery-item" onclick="openLightbox('{{ asset($gallery->image) }}', '{{ $gallery->title }}', '{{ $gallery->description }}')">
                        <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->title }}" class="gallery-image" loading="lazy">
                        <div class="gallery-info">
                            @if($gallery->category)
                                <div class="gallery-category">{{ $gallery->category->name }}</div>
                            @endif
                            <h3 class="gallery-title">{{ $gallery->title }}</h3>
                            @if($gallery->description)
                                <p class="gallery-description">{{ Str::limit($gallery->description, 100) }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 3rem; display: flex; justify-content: center;">
                {{ $galleries->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 4rem 2rem; color: #6c757d;">
                <i class="fas fa-images" style="font-size: 4rem; color: #dee2e6; margin-bottom: 1.5rem;"></i>
                <h3 style="font-size: 1.5rem; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem;">No Images Found</h3>
                <p>Check back later for new gallery items.</p>
            </div>
        @endif
    </div>
</div>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <div class="lightbox-content" onclick="event.stopPropagation()">
        <button class="lightbox-close" onclick="closeLightbox()">×</button>
        <img src="" alt="" class="lightbox-image" id="lightbox-image">
        <div class="lightbox-info">
            <h3 id="lightbox-title"></h3>
            <p id="lightbox-description"></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openLightbox(image, title, description) {
        document.getElementById('lightbox').classList.add('active');
        document.getElementById('lightbox-image').src = image;
        document.getElementById('lightbox-title').textContent = title;
        document.getElementById('lightbox-description').textContent = description;
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Close lightbox on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>
@endpush
