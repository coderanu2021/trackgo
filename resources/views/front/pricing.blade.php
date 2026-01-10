@extends('layouts.front')

@section('title', 'Pricing Plans - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<div style="background: var(--bg-light); padding: 8rem 0; text-align: center; border-bottom: 1px solid var(--border);">
    <div class="container">
        <h1 style="font-size: 3.5rem; font-weight: 800; letter-spacing: -0.04em; margin-bottom: 1.5rem; color: var(--secondary);">Strategic Pricing</h1>
        <p style="color: var(--text-muted); font-size: 1.25rem; max-width: 700px; margin: 0 auto; line-height: 1.6;">
            Choose the perfect plan for your creative ambitions. Scalable solutions designed for individuals and fast-growing teams.
        </p>
    </div>
</div>

<div class="container" style="padding: 6rem 0;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; align-items: flex-start;">
        @foreach($plans as $plan)
        <div style="background: white; border: 1px solid {{ $plan->is_featured ? 'var(--primary)' : 'var(--border)' }}; border-radius: 20px; padding: 3.5rem 2.5rem; position: relative; transition: 0.4s; {{ $plan->is_featured ? 'box-shadow: 0 20px 40px rgba(99, 102, 241, 0.1); transform: scale(1.05); z-index: 10;' : '' }}"
             onmouseover="this.style.boxShadow='0 15px 30px rgba(0,0,0,0.05)';"
             onmouseout="this.style.boxShadow='{{ $plan->is_featured ? '0 20px 40px rgba(99, 102, 241, 0.1)' : 'none' }}';">
            
            @if($plan->is_featured)
            <div style="position: absolute; top: 0; left: 50%; transform: translate(-50%, -50%); background: var(--primary); color: white; padding: 0.5rem 1.5rem; border-radius: 30px; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Most Popular
            </div>
            @endif

            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem; color: var(--secondary);">{{ $plan->name }}</h3>
            <div style="display: flex; align-items: baseline; gap: 0.25rem; margin-bottom: 2rem;">
                <span style="font-size: 1.5rem; font-weight: 700; color: var(--text-muted);">$</span>
                <span style="font-size: 3.5rem; font-weight: 800; color: var(--secondary); font-family: 'Outfit', sans-serif;">{{ number_format($plan->price, 0) }}</span>
                <span style="color: var(--text-muted); font-weight: 600;">/{{ $plan->cycle }}</span>
            </div>

            <div style="margin-bottom: 2.5rem;">
                @php $features = json_decode($plan->features) @endphp
                @if($features)
                    @foreach($features as $feature)
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; color: var(--text);">
                        <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.1rem;"></i>
                        <span style="font-weight: 500;">{{ $feature }}</span>
                    </div>
                    @endforeach
                @endif
            </div>

            <a href="#" class="btn {{ $plan->is_featured ? 'btn-primary' : '' }}" style="width: 100%; justify-content: center; padding: 1.25rem; font-weight: 800; border: 1px solid {{ $plan->is_featured ? 'var(--primary)' : 'var(--border)' }}; background: {{ $plan->is_featured ? 'var(--primary)' : 'transparent' }}; color: {{ $plan->is_featured ? 'white' : 'var(--secondary)' }};">
                Get Started
            </a>
        </div>
        @endforeach
    </div>

    <!-- FAQ CTA -->
    <div style="margin-top: 8rem; background: var(--secondary); border-radius: 20px; padding: 5rem; text-align: center; color: white;">
        <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1.5rem;">Need a custom solution?</h2>
        <p style="color: rgba(255,255,255,0.7); font-size: 1.25rem; max-width: 600px; margin: 0 auto 3rem;">
            Whether you need dedicated servers or custom integrations, our team is ready to help you build exactly what you need.
        </p>
        <a href="{{ route('contact') }}" class="btn btn-primary" style="padding: 1.25rem 3rem; font-size: 1.1rem;">Contact Sales Team</a>
    </div>
</div>
@endsection
