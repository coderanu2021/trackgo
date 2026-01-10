@extends('layouts.front')

@section('title', 'Frequently Asked Questions - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<div style="background: var(--bg-light); padding: 8rem 0; text-align: center; border-bottom: 1px solid var(--border);">
    <div class="container">
        <h1 style="font-size: 3.5rem; font-weight: 800; letter-spacing: -0.04em; margin-bottom: 1.5rem; color: var(--secondary);">Got Questions?</h1>
        <p style="color: var(--text-muted); font-size: 1.25rem; max-width: 700px; margin: 0 auto; line-height: 1.6;">
            Everything you need to know about TrackGo and our premium ecosystem. Browse through our most requested topics.
        </p>
    </div>
</div>

<div class="container" style="padding: 6rem 0; max-width: 900px;">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        @foreach($faqs as $faq)
        <div style="background: white; border: 1px solid var(--border); border-radius: 16px; overflow: hidden; transition: 0.3s;" class="faq-item">
            <button style="width: 100%; padding: 2rem; display: flex; align-items: center; justify-content: space-between; background: transparent; border: none; cursor: pointer; text-align: left;" onclick="toggleFaq(this)">
                <span style="font-size: 1.2rem; font-weight: 700; color: var(--secondary); font-family: 'Outfit', sans-serif;">{{ $faq->question }}</span>
                <i class="fas fa-plus" style="transition: 0.4s; color: var(--primary);"></i>
            </button>
            <div style="max-height: 0; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); background: var(--bg-light);" class="faq-answer">
                <div style="padding: 2rem; color: var(--text); line-height: 1.8; font-size: 1.05rem; border-top: 1px solid var(--border);">
                    {{ $faq->answer }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div style="margin-top: 6rem; text-align: center;">
        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem;">Can't find what you're looking for?</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">Our support team is always here to help you.</p>
        <a href="{{ route('contact') }}" class="btn btn-primary" style="padding: 1rem 2.5rem;">Ask a Question</a>
    </div>
</div>

<script>
    function toggleFaq(btn) {
        const item = btn.parentElement;
        const answer = item.querySelector('.faq-answer');
        const icon = btn.querySelector('i');
        
        // Close others
        document.querySelectorAll('.faq-item').forEach(other => {
            if (other !== item) {
                other.querySelector('.faq-answer').style.maxHeight = null;
                other.querySelector('i').className = 'fas fa-plus';
                other.style.borderColor = 'var(--border)';
            }
        });

        if (answer.style.maxHeight) {
            answer.style.maxHeight = null;
            icon.className = 'fas fa-plus';
            item.style.borderColor = 'var(--border)';
        } else {
            answer.style.maxHeight = answer.scrollHeight + "px";
            icon.className = 'fas fa-minus';
            item.style.borderColor = 'var(--primary)';
        }
    }
</script>
@endsection
