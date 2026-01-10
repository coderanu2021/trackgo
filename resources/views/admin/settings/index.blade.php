@extends('layouts.admin')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1>Global Settings</h1>
    <p style="color: var(--text-muted);">Configure your website's contact and navigation details.</p>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" style="max-width: 1000px;" enctype="multipart/form-data">
    @csrf
    
    <div class="form-row">
        <!-- General Configuration -->
        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem;">
                <i class="fas fa-cog" style="color:var(--primary); margin-right: 0.5rem;"></i> General Configuration
            </h3>
            <div class="form-group">
                <label>Site Name</label>
                <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}" placeholder="Your Website Name">
            </div>
            <div class="form-group">
                <label>Support Email</label>
                <input type="email" name="site_email" class="form-control" value="{{ $settings['site_email'] ?? '' }}" placeholder="support@example.com">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Site Logo (PNG/SVG)</label>
                    <input type="file" name="site_logo" class="form-control" style="padding: 0.5rem; border: 1px dashed var(--border-base);">
                    @if(isset($settings['site_logo']))
                        <div class="mt-2"><img src="{{ asset($settings['site_logo']) }}" height="30" alt="Site Logo"></div>
                    @endif
                </div>
                <div class="form-group">
                    <label>Site Favicon (ICO/PNG)</label>
                    <input type="file" name="site_favicon" class="form-control" style="padding: 0.5rem; border: 1px dashed var(--border-base);">
                    @if(isset($settings['site_favicon']))
                        <div class="mt-2"><img src="{{ asset($settings['site_favicon']) }}" height="20" alt="Site Favicon"></div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label>Physical Address</label>
                <textarea name="site_address" class="form-control" rows="2" placeholder="123 Business St, Suite 100">{{ $settings['site_address'] ?? '' }}</textarea>
            </div>
            <div class="form-group mb-0">
                <label>Phone Number</label>
                <input type="text" name="site_phone" class="form-control" value="{{ $settings['site_phone'] ?? '' }}" placeholder="+1 234 567 890">
            </div>
        </div>

        <!-- Social Links -->
        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem;">
                <i class="fas fa-share-alt" style="color:var(--primary); margin-right: 0.5rem;"></i> Social Media
            </h3>
            <div id="social-container">
                @php
                    $socials = json_decode($settings['social_links'] ?? '[]', true);
                @endphp
                @foreach($socials as $social)
                <div class="form-row" style="grid-template-columns: 1fr 2fr; margin-bottom: 1rem;">
                    <input type="text" name="social_platform[]" placeholder="Platform" class="form-control" value="{{ $social['platform'] }}">
                    <input type="text" name="social_url[]" placeholder="URL" class="form-control" value="{{ $social['url'] }}">
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addSocial()" class="btn btn-secondary" style="width: 100%; justify-content: center;">
                <i class="fas fa-plus"></i> Add Social Link
            </button>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="card" style="margin-top: 2rem;">
        <h3 style="margin-top: 0; margin-bottom: 1.5rem;">
            <i class="fas fa-bars" style="color:var(--primary); margin-right: 0.5rem;"></i> Main Navigation Menu
        </h3>
        <div id="menu-container" class="form-row" style="grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));">
            @php
                $menu = json_decode($settings['main_menu'] ?? '[]', true);
            @endphp
            @foreach($menu as $item)
            <div class="form-row" style="padding: 1rem; border: 1px solid var(--border-soft); border-radius: var(--radius-md); background: var(--bg-main);">
                <input type="text" name="menu_label[]" placeholder="Label" class="form-control" value="{{ $item['label'] }}">
                <input type="text" name="menu_url[]" placeholder="URL" class="form-control" value="{{ $item['url'] }}">
            </div>
            @endforeach
        </div>
        <button type="button" onclick="addMenu()" class="btn btn-secondary" style="margin-top: 1.5rem;">
            <i class="fas fa-plus"></i> Add Menu Item
        </button>
    </div>

    <!-- Footer Configuration -->
    <div class="card" style="margin-top: 2rem;">
        <h3 style="margin-top: 0; margin-bottom: 1.5rem;">
            <i class="fas fa-shoe-prints" style="color:var(--primary); margin-right: 0.5rem;"></i> Footer Configuration
        </h3>
        
        <div class="form-group">
            <label>Footer 'About Us' Text</label>
            <textarea name="site_footer_about" class="form-control" rows="3" placeholder="Brief description of your company for the footer...">{{ $settings['site_footer_about'] ?? '' }}</textarea>
        </div>

        <div class="form-row" style="margin-top: 2rem;">
            <!-- Quick Links -->
            <div>
                <label style="display:flex; justify-content:space-between; align-items:center;">
                    Quick Links
                    <button type="button" onclick="addFooterLink('quick')" class="btn btn-secondary" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;">
                        <i class="fas fa-plus"></i>
                    </button>
                </label>
                <div id="quick-links-container">
                    @php $quickLinks = json_decode($settings['footer_quick_links'] ?? '[]', true); @endphp
                    @foreach($quickLinks as $link)
                    <div class="form-row" style="margin-bottom: 0.75rem;">
                        <input type="text" name="footer_quick_label[]" placeholder="Label" class="form-control" value="{{ $link['label'] }}">
                        <input type="text" name="footer_quick_url[]" placeholder="URL" class="form-control" value="{{ $link['url'] }}">
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Company Links -->
            <div>
                <label style="display:flex; justify-content:space-between; align-items:center;">
                    Company Links
                    <button type="button" onclick="addFooterLink('company')" class="btn btn-secondary" style="padding: 0.25rem 0.6rem; font-size: 0.75rem;">
                        <i class="fas fa-plus"></i>
                    </button>
                </label>
                <div id="company-links-container">
                    @php $companyLinks = json_decode($settings['footer_company_links'] ?? '[]', true); @endphp
                    @foreach($companyLinks as $link)
                    <div class="form-row" style="margin-bottom: 0.75rem;">
                        <input type="text" name="footer_company_label[]" placeholder="Label" class="form-control" value="{{ $link['label'] }}">
                        <input type="text" name="footer_company_url[]" placeholder="URL" class="form-control" value="{{ $link['url'] }}">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 2rem;">
        <h3 style="margin-top: 0; margin-bottom: 1.5rem;">
            <i class="fas fa-file-invoice" style="color:var(--primary); margin-right: 0.5rem;"></i> Dynamic Page Content
        </h3>
        <div class="form-row">
            <div>
                <h4 style="margin-bottom: 1rem; color: var(--text-muted); font-size: 0.9rem;">About Page</h4>
                <div class="form-group">
                    <label>About Page Title</label>
                    <input type="text" name="site_about_title" class="form-control" value="{{ $settings['site_about_title'] ?? 'Crafting Tomorrow\'s Technology' }}">
                </div>
                <div class="form-group mb-0">
                    <label>Our Narrative (About Content)</label>
                    <textarea name="site_about_content" class="form-control" rows="8">{{ $settings['site_about_content'] ?? '' }}</textarea>
                </div>
            </div>
            <div>
                <h4 style="margin-bottom: 1rem; color: var(--text-muted); font-size: 0.9rem;">Contact Page & Misc</h4>
                <div class="form-group">
                    <label>Google Maps Embed (URL/Iframe)</label>
                    <textarea name="site_contact_map" class="form-control" rows="4">{{ $settings['site_contact_map'] ?? '' }}</textarea>
                </div>
                <div class="form-group mb-0">
                    <label>Footer Elevator Pitch</label>
                    <textarea name="site_footer_about" class="form-control" rows="4" placeholder="Brief elevator pitch for footer...">{{ $settings['site_footer_about'] ?? '' }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
        <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem; font-size: 1rem;">
            <i class="fas fa-save"></i> Save Global Settings
        </button>
    </div>
</form>

<script>
function addSocial() {
    const div = document.createElement('div');
    div.style.display = 'flex';
    div.style.gap = '0.5rem';
    div.style.marginBottom = '0.75rem';
    div.innerHTML = `
        <input type="text" name="social_platform[]" placeholder="Platform" class="form-control">
        <input type="text" name="social_url[]" placeholder="URL" class="form-control">
    `;
    document.getElementById('social-container').appendChild(div);
}

function addMenu() {
    const div = document.createElement('div');
    div.style.display = 'flex';
    div.style.gap = '0.5rem';
    div.style.border = '1px solid var(--border)';
    div.style.padding = '0.75rem';
    div.style.borderRadius = 'var(--radius-md)';
    div.innerHTML = `
        <input type="text" name="menu_label[]" placeholder="Label" class="form-control">
        <input type="text" name="menu_url[]" placeholder="URL" class="form-control">
    `;
    document.getElementById('menu-container').appendChild(div);
}

function addFooterLink(type) {
    const div = document.createElement('div');
    div.style.display = 'flex';
    div.style.gap = '0.5rem';
    div.style.marginBottom = '0.5rem';
    div.innerHTML = `
        <input type="text" name="footer_${type}_label[]" placeholder="Label" class="form-control">
        <input type="text" name="footer_${type}_url[]" placeholder="URL" class="form-control">
    `;
    document.getElementById(`${type}-links-container`).appendChild(div);
}
</script>
@endsection
