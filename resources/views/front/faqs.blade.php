@extends('layouts.front')

@section('title', 'Frequently Asked Questions - ' . ($settings['site_name'] ?? 'TrackGo'))

@push('styles')
<style>
    .faq-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 4rem 2rem;
    }
    
    .faq-item {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .faq-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .faq-item.active {
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(243, 112, 33, 0.15);
    }
    
    .faq-question {
        width: 100%;
        padding: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: transparent;
        border: none;
        cursor: pointer;
        text-align: left;
        transition: all 0.3s ease;
    }
    
    .faq-question:hover {
        background: #f8fafc;
    }
    
    .faq-question-text {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--secondary);
        font-family: 'Outfit', sans-serif;
        line-height: 1.4;
        margin-right: 1rem;
    }
    
    .faq-icon {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        color: var(--primary);
        font-size: 1.1rem;
        min-width: 20px;
        text-align: center;
    }
    
    .faq-item.active .faq-icon {
        transform: rotate(45deg);
    }
    
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: #f8fafc;
    }
    
    .faq-answer.active {
        max-height: 500px; /* Fallback for very long answers */
    }
    
    .faq-answer-content {
        padding: 2rem;
        color: #4a5568;
        line-height: 1.8;
        font-size: 1.05rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .faq-category {
        display: inline-block;
        background: rgba(243, 112, 33, 0.1);
        color: var(--primary);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    @media (max-width: 768px) {
        .faq-container {
            padding: 2rem 1rem;
        }
        
        .faq-question {
            padding: 1.5rem;
        }
        
        .faq-question-text {
            font-size: 1.1rem;
        }
        
        .faq-answer-content {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div style="background: var(--bg-light); padding: 4rem 0; text-align: center; border-bottom: 1px solid var(--border);">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 800; letter-spacing: -0.04em; margin-bottom: 1rem; color: var(--secondary);">Got Questions?</h1>
        <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
            Everything you need to know about Etrackgo and our GPS tracking solutions. Browse through our most requested topics.
        </p>
    </div>
</div>

<div class="faq-container">
    @php
        $groupedFaqs = $faqs->groupBy('category');
    @endphp
    
    @foreach($groupedFaqs as $category => $categoryFaqs)
        @if($category)
            <div style="margin-bottom: 3rem;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--secondary); margin-bottom: 2rem; padding-left: 1rem; border-left: 4px solid var(--primary);">
                    {{ $category }}
                </h2>
                
                @foreach($categoryFaqs as $faq)
                <div class="faq-item" data-faq-id="{{ $faq->id }}">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <div>
                            <div class="faq-category">{{ $faq->category }}</div>
                            <div class="faq-question-text">{{ $faq->question }}</div>
                        </div>
                        <i class="fas fa-plus faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            @foreach($categoryFaqs as $faq)
            <div class="faq-item" data-faq-id="{{ $faq->id }}">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <div>
                        @if($faq->category)
                            <div class="faq-category">{{ $faq->category }}</div>
                        @endif
                        <div class="faq-question-text">{{ $faq->question }}</div>
                    </div>
                    <i class="fas fa-plus faq-icon"></i>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    @endforeach

    <div style="margin-top: 6rem; text-align: center; background: white; padding: 3rem; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: var(--secondary);">Can't find what you're looking for?</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">Our support team is always here to help you with your GPS tracking needs.</p>
        <a href="{{ route('contact') }}" class="btn btn-primary" style="padding: 1rem 2.5rem; border-radius: 12px; text-decoration: none; display: inline-block;">Ask a Question</a>
    </div>
</div>

@push('scripts')
<script>
    function toggleFaq(button) {
        try {
            const faqItem = button.closest('.faq-item');
            const answer = faqItem.querySelector('.faq-answer');
            const icon = button.querySelector('.faq-icon');
            const isActive = faqItem.classList.contains('active');
            
            // Close all other FAQs
            document.querySelectorAll('.faq-item').forEach(item => {
                if (item !== faqItem) {
                    item.classList.remove('active');
                    const otherAnswer = item.querySelector('.faq-answer');
                    const otherIcon = item.querySelector('.faq-icon');
                    
                    if (otherAnswer) {
                        otherAnswer.classList.remove('active');
                        otherAnswer.style.maxHeight = '0px';
                    }
                    if (otherIcon) {
                        otherIcon.className = 'fas fa-plus faq-icon';
                    }
                }
            });
            
            // Toggle current FAQ
            if (isActive) {
                // Close current FAQ
                faqItem.classList.remove('active');
                answer.classList.remove('active');
                answer.style.maxHeight = '0px';
                icon.className = 'fas fa-plus faq-icon';
            } else {
                // Open current FAQ
                faqItem.classList.add('active');
                answer.classList.add('active');
                
                // Calculate and set max-height
                const content = answer.querySelector('.faq-answer-content');
                if (content) {
                    const contentHeight = content.scrollHeight;
                    answer.style.maxHeight = (contentHeight + 40) + 'px'; // Add padding
                }
                
                icon.className = 'fas fa-plus faq-icon'; // Keep plus, rotation handled by CSS
            }
        } catch (error) {
            console.error('FAQ toggle error:', error);
        }
    }
    
    // Initialize FAQ functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure all FAQs start closed
        document.querySelectorAll('.faq-answer').forEach(answer => {
            answer.style.maxHeight = '0px';
        });
        
        // Add keyboard support
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleFaq(this);
                }
            });
        });
    });
</script>
@endpush
@endsection
