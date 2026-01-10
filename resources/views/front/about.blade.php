@extends('layouts.front')

@section('title', 'About Our Mission - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<!-- Hero Section -->
<div style="background: var(--bg-light); padding: 8rem 0; border-bottom: 1px solid var(--border); overflow: hidden; position: relative;">
    <div class="container" style="position: relative; z-index: 2;">
        <div style="max-width: 800px; margin: 0 auto; text-align: center;">
            <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 0.5rem 1.25rem; border-radius: 30px; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 2rem;">
                <i class="fas fa-rocket"></i> Our Vision
            </div>
            <h1 style="font-size: 4rem; font-weight: 800; letter-spacing: -0.04em; line-height: 1.1; margin-bottom: 2rem; color: var(--secondary); font-family: 'Outfit', sans-serif;">
                {{ $settings['site_about_title'] ?? 'Building the Future of Digital Commerce' }}
            </h1>
            <p style="color: var(--text-muted); font-size: 1.25rem; line-height: 1.7; margin-bottom: 0;">
                We are more than just a platform. We are your partner in creative excellence and strategic growth.
            </p>
        </div>
    </div>
    
    <!-- Abstract Decoration -->
    <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(99,102,241,0.05) 0%, transparent 70%); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -150px; left: -150px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(99,102,241,0.03) 0%, transparent 70%); border-radius: 50%;"></div>
</div>

<!-- Story Section -->
<div class="container" style="padding: 10rem 0;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6rem; align-items: center;">
        <div style="position: relative;">
            <div style="border-radius: 30px; overflow: hidden; box-shadow: 0 40px 80px rgba(0,0,0,0.15); border: 1px solid var(--border);">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=1200&auto=format&fit=crop" style="width:100%; display: block;" alt="Our Creative Team">
            </div>
            <!-- Floating Achievement -->
            <div style="position: absolute; bottom: -30px; right: -30px; background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); border: 1px solid var(--border); display: flex; align-items: center; gap: 1.5rem;">
                <div style="width: 60px; height: 60px; background: var(--primary); color: white; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--secondary);">Top Rated</div>
                    <div style="font-size: 0.9rem; color: var(--text-muted);">Trusted Platform 2026</div>
                </div>
            </div>
        </div>
        
        <div>
            <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 2rem; color: var(--secondary); font-family: 'Outfit', sans-serif;">Our Narrative</h2>
            <div style="font-size: 1.15rem; color: var(--text); line-height: 1.9;">
                {!! nl2br(e($settings['site_about_content'] ?? 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.')) !!}
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-top: 4rem; padding-top: 3rem; border-top: 1px solid var(--border);">
                <div>
                    <strong style="display:block; font-size:3rem; color:var(--primary); font-family: 'Outfit', sans-serif; letter-spacing: -0.05em;">10K+</strong>
                    <span style="color:var(--text-muted); font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.05em;">Global Partners</span>
                </div>
                <div>
                    <strong style="display:block; font-size:3rem; color:var(--primary); font-family: 'Outfit', sans-serif; letter-spacing: -0.05em;">15+</strong>
                    <span style="color:var(--text-muted); font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.05em;">Years Innovation</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div style="padding-bottom: 8rem;">
    <div class="container">
        <div style="background: var(--secondary); border-radius: 30px; padding: 6rem; position: relative; overflow: hidden; color: white; text-align: center;">
            <div style="position: relative; z-index: 2;">
                <h2 style="font-size: 3rem; font-weight: 800; margin-bottom: 1.5rem; font-family: 'Outfit', sans-serif;">Interested in joining us?</h2>
                <p style="color: rgba(255,255,255,0.7); font-size: 1.25rem; max-width: 600px; margin: 0 auto 3rem;">
                    We are always looking for visionary partners and talented individuals to help us build the future.
                </p>
                <div style="display: flex; gap: 1.5rem; justify-content: center;">
                    <a href="{{ route('contact') }}" class="btn btn-primary" style="padding: 1.25rem 3rem;">Collaborate With Us</a>
                    <a href="{{ route('pricing') }}" class="btn" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white; padding: 1.25rem 3rem;">View Our Plans</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
