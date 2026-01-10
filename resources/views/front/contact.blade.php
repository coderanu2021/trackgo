@extends('layouts.front')

@section('title', 'Connect With Us - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<!-- Header -->
<div style="background: var(--bg-light); padding: 8rem 0; border-bottom: 1px solid var(--border);">
    <div class="container" style="text-align: center;">
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 0.5rem 1.25rem; border-radius: 30px; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 2rem;">
            <i class="fas fa-headset"></i> Support Center
        </div>
        <h1 style="font-size: 4rem; font-weight: 800; letter-spacing: -0.04em; margin-bottom: 1.5rem; color: var(--secondary); font-family: 'Outfit', sans-serif;">Connect with our Experts</h1>
        <p style="color: var(--text-muted); font-size: 1.25rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
            Have a question or a bold idea? We're here to provide the insights and assistance you need to succeed.
        </p>
    </div>
</div>

<div class="container" style="padding: 8rem 0;">
    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 6rem;">
        <!-- Contact Info -->
        <div>
            <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 3rem; color: var(--secondary); font-family: 'Outfit', sans-serif;">Reach Out</h2>
            
            <div style="display: flex; flex-direction: column; gap: 3rem;">
                <div style="display: flex; gap: 1.5rem;">
                    <div style="width: 50px; height: 50px; background: white; border: 1px solid var(--border); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); flex-shrink: 0;">
                        <i class="fas fa-location-dot"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--secondary);">Our Headquarters</h4>
                        <p style="color: var(--text-muted); line-height: 1.6;">{{ $settings['site_address'] ?? '123 Business St, Creative District, New York' }}</p>
                    </div>
                </div>

                <div style="display: flex; gap: 1.5rem;">
                    <div style="width: 50px; height: 50px; background: white; border: 1px solid var(--border); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); flex-shrink: 0;">
                        <i class="fas fa-phone-volume"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--secondary);">Priority Connection</h4>
                        <p style="color: var(--text-muted); line-height: 1.6;">{{ $settings['site_phone'] ?? '+1 234 567 890' }}</p>
                    </div>
                </div>

                <div style="display: flex; gap: 1.5rem;">
                    <div style="width: 50px; height: 50px; background: white; border: 1px solid var(--border); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); flex-shrink: 0;">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--secondary);">Digital Correspondence</h4>
                        <p style="color: var(--text-muted); line-height: 1.6;">{{ $settings['site_email'] ?? 'support@trackgo.com' }}</p>
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div style="margin-top: 5rem; padding-top: 4rem; border-top: 1px solid var(--border);">
                <h4 style="font-size: 0.9rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 1.5rem;">Follow Our Journey</h4>
                <div style="display: flex; gap: 1rem;">
                    @php $socials = json_decode($settings['social_links'] ?? '[]', true); @endphp
                    @foreach($socials as $social)
                        <a href="{{ $social['url'] }}" target="_blank" style="width: 45px; height: 45px; background: var(--secondary); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: 0.3s;" onmouseover="this.style.background='var(--primary)';" onmouseout="this.style.background='var(--secondary)';">
                            <i class="fab fa-{{ strtolower($social['platform']) }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Form -->
        <div>
            <div style="background: white; padding: 4rem; border: 1px solid var(--border); border-radius: 24px; box-shadow: 0 20px 50px rgba(0,0,0,0.05);">
                <form action="#" method="POST">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                        <div class="form-group">
                            <label style="display:block; margin-bottom:0.75rem; font-weight:600; color:var(--secondary); font-size: 0.9rem;">Full Name</label>
                            <input type="text" name="name" class="form-control" style="background: var(--bg-light); border-color: var(--border-soft);" placeholder="Jane Doe" required>
                        </div>
                        <div class="form-group">
                            <label style="display:block; margin-bottom:0.75rem; font-weight:600; color:var(--secondary); font-size: 0.9rem;">Email Address</label>
                            <input type="email" name="email" class="form-control" style="background: var(--bg-light); border-color: var(--border-soft);" placeholder="jane@example.com" required>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label style="display:block; margin-bottom:0.75rem; font-weight:600; color:var(--secondary); font-size: 0.9rem;">Subject / Department</label>
                        <select class="form-control" style="background: var(--bg-light); border-color: var(--border-soft);">
                            <option>Technical Inquiry</option>
                            <option>Partnership Proposal</option>
                            <option>Sales & Licensing</option>
                            <option>General Message</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 2.5rem;">
                        <label style="display:block; margin-bottom:0.75rem; font-weight:600; color:var(--secondary); font-size: 0.9rem;">Your Message</label>
                        <textarea rows="6" class="form-control" style="background: var(--bg-light); border-color: var(--border-soft);" placeholder="Tell us how we can assist you..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%; padding: 1.25rem; font-size: 1.1rem; font-weight: 800; justify-content: center;">
                        Establish Connection <i class="fas fa-paper-plane" style="margin-left:0.75rem; font-size: 0.9rem;"></i>
                    </button>
                </form>
            </div>
            
            @if(isset($settings['site_contact_map']) && $settings['site_contact_map'])
                <div style="margin-top: 3rem; border-radius: 20px; overflow: hidden; height: 300px; border: 1px solid var(--border);">
                    {!! $settings['site_contact_map'] !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
