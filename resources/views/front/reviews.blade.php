@extends('layouts.front')

@section('title', 'Customer Reviews')

@section('content')
<style>
    @media (max-width: 768px) {
        .reviews-header { margin-bottom: 3rem !important; }
        .reviews-header h1 { font-size: 2.25rem !important; }
        .reviews-grid { grid-template-columns: 1fr !important; }
    }
</style>
<section style="padding: 6rem 0; background: var(--bg-light);">
    <div class="container">
        <div class="reviews-header" style="text-align: center; margin-bottom: 5rem;">
            <h1 style="font-size: 3rem; font-weight: 900; color: var(--secondary); margin-bottom: 1rem; letter-spacing: -0.04em;">Customer Voices</h1>
            <p style="font-size: 1.25rem; color: var(--text-muted); max-width: 700px; margin: 0 auto; line-height: 1.6;">
                Real feedback from real users. Discover how our premium products are transforming businesses worldwide.
            </p>
        </div>

        <div class="reviews-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2.5rem;">
            @foreach($reviews as $review)
                <div style="background: white; border-radius: 24px; padding: 2.5rem; box-shadow: var(--shadow-md); border: 1px solid var(--border-soft); display: flex; flex-direction: column; height: 100%;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                        <div>
                            <div style="font-weight: 800; color: var(--secondary); font-size: 1.15rem;">{{ $review->name }}</div>
                            <div style="font-size: 0.85rem; color: var(--text-light);">{{ $review->created_at->format('M d, Y') }}</div>
                        </div>
                        <div style="color: #ffc107; font-size: 0.85rem;">
                            @for($i=1; $i<=5; $i++)
                                <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    
                    <p style="font-size: 1rem; line-height: 1.7; color: var(--text-main); margin-bottom: 1.5rem; flex: 1;">
                        "{{ $review->comment }}"
                    </p>

                    @if(!empty($review->images))
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem;">
                            @foreach($review->images as $img)
                                <img src="{{ $img }}" style="width: 60px; height: 60px; border-radius: 10px; object-fit: cover;">
                            @endforeach
                        </div>
                    @endif

                    <div style="padding-top: 1.5rem; border-top: 1px solid var(--border-soft); display: flex; align-items: center; gap: 1rem;">
                        <img src="{{ $review->product->thumbnail }}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                        <div style="overflow: hidden;">
                            <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.05em;">Reviewing</div>
                            <a href="{{ route('products.show', $review->product->slug) }}" style="font-weight: 700; color: var(--primary); font-size: 0.95rem; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $review->product->title }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 5rem; display: flex; justify-content: center;">
            {{ $reviews->links() }}
        </div>
    </div>
</section>
@endsection
