@extends('layouts.admin')

@section('content')
<div class="container" style="max-width: 800px;">
    <h1>Global Site Settings</h1>
    
    @if(session('success'))
        <div style="background:#d1fae5; color:#065f46; padding:1rem; border-radius:4px; margin-bottom:1rem;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        <!-- Contact Info -->
        <div class="glass" style="padding:1.5rem; margin-bottom:2rem;">
            <h2>Contact Information</h2>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="site_phone" class="form-input" value="{{ $settings['site_phone'] ?? '' }}">
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" name="site_email" class="form-input" value="{{ $settings['site_email'] ?? '' }}">
            </div>
            <div class="form-group">
                <label>Office Address</label>
                <textarea name="site_address" class="form-input">{{ $settings['site_address'] ?? '' }}</textarea>
            </div>
        </div>

        <!-- Social Links (Dynamic Array) -->
        <div class="glass" style="padding:1.5rem; margin-bottom:2rem;">
            <h2>Social Media Links</h2>
            <div id="social-container">
                @php
                    $socials = json_decode($settings['social_links'] ?? '[]', true);
                @endphp
                @foreach($socials as $social)
                <div class="flex gap-4" style="margin-bottom:0.5rem;">
                    <input type="text" name="social_platform[]" placeholder="Platform (e.g. Facebook)" class="form-input" value="{{ $social['platform'] }}">
                    <input type="text" name="social_url[]" placeholder="URL" class="form-input" value="{{ $social['url'] }}">
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addSocial()" class="btn-secondary">+ Add Social Link</button>
        </div>

        <!-- Navigation Menu (Dynamic Array) -->
        <div class="glass" style="padding:1.5rem; margin-bottom:2rem;">
            <h2>Main Navigation Menu</h2>
            <div id="menu-container">
                @php
                    $menu = json_decode($settings['main_menu'] ?? '[]', true);
                @endphp
                @foreach($menu as $item)
                <div class="flex gap-4" style="margin-bottom:0.5rem;">
                    <input type="text" name="menu_label[]" placeholder="Label (e.g. Home)" class="form-input" value="{{ $item['label'] }}">
                    <input type="text" name="menu_url[]" placeholder="URL (e.g. /about)" class="form-input" value="{{ $item['url'] }}">
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addMenu()" class="btn-secondary">+ Add Menu Item</button>
        </div>

        <button type="submit" class="btn-primary">Save Settings</button>
    </form>
</div>

<script>
function addSocial() {
    const div = document.createElement('div');
    div.className = 'flex gap-4';
    div.style.marginBottom = '0.5rem';
    div.innerHTML = `
        <input type="text" name="social_platform[]" placeholder="Platform" class="form-input">
        <input type="text" name="social_url[]" placeholder="URL" class="form-input">
    `;
    document.getElementById('social-container').appendChild(div);
}

function addMenu() {
    const div = document.createElement('div');
    div.className = 'flex gap-4';
    div.style.marginBottom = '0.5rem';
    div.innerHTML = `
        <input type="text" name="menu_label[]" placeholder="Label" class="form-input">
        <input type="text" name="menu_url[]" placeholder="URL" class="form-input">
    `;
    document.getElementById('menu-container').appendChild(div);
}
</script>
@endsection
