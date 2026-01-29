@extends('layouts.admin')

@section('content')
<div class="settings-header" style="margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem; letter-spacing: -0.02em;">Global Settings</h1>
        <p style="color: var(--text-muted); font-size: 1.05rem;">Manage your website's identity, branding, and core configurations.</p>
    </div>
    <div class="quick-actions">
        <button type="button" onclick="document.getElementById('settings-form').submit();" class="btn btn-primary" style="padding: 0.875rem 2rem; border-radius: 12px;">
            <i class="fas fa-save"></i> Save All Changes
        </button>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" id="settings-form" enctype="multipart/form-data">
    @csrf
    
    <div class="settings-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;">
        
        <!-- Left Column -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            
            <!-- General Branding -->
            <div class="card" style="padding: 2rem; border-radius: 20px;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--primary-soft); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                        <i class="fas fa-fingerprint" style="font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700;">Identity & Branding</h3>
                        <p style="margin:0; font-size: 0.85rem; color: var(--text-muted);">Name, Logo and brand identity</p>
                    </div>
                </div>

                <div class="form-row" style="grid-template-columns: 2fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Site Name</label>
                        <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}" placeholder="Enter site name">
                    </div>
                    <div class="form-group">
                        <label>Currency</label>
                        <input type="text" name="site_currency" class="form-control" value="{{ $settings['site_currency'] ?? 'INR' }}" placeholder="e.g. INR, ₹">
                    </div>
                </div>

                <div class="form-row" style="grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Primary Color</label>
                        <div style="display: flex; gap: 0.75rem; align-items: center; background: #f8fafc; padding: 0.5rem; border-radius: 12px; border: 1px solid var(--border-base);">
                            <input type="color" name="site_primary_color" style="width: 44px; height: 44px; padding: 0; border: none; background: none; cursor: pointer; border-radius: 8px; overflow: hidden;" value="{{ $settings['site_primary_color'] ?? '#6366f1' }}">
                            <span style="font-family: monospace; font-weight: 600; color: var(--text-main); font-size: 0.9rem;">{{ $settings['site_primary_color'] ?? '#6366f1' }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Secondary Color</label>
                        <div style="display: flex; gap: 0.75rem; align-items: center; background: #f8fafc; padding: 0.5rem; border-radius: 12px; border: 1px solid var(--border-base);">
                            <input type="color" name="site_secondary_color" style="width: 44px; height: 44px; padding: 0; border: none; background: none; cursor: pointer; border-radius: 8px; overflow: hidden;" value="{{ $settings['site_secondary_color'] ?? '#0f172a' }}">
                            <span style="font-family: monospace; font-weight: 600; color: var(--text-main); font-size: 0.9rem;">{{ $settings['site_secondary_color'] ?? '#0f172a' }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-row" style="grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
                    <div class="form-group">
                        <label>Website Logo</label>
                        <div style="border: 2px dashed #e2e8f0; border-radius: 16px; padding: 1.5rem; text-align: center; background: #fff; min-height: 180px; display: flex; flex-direction: column; justify-content: center;">
                            @if(isset($settings['site_logo']))
                                <div style="margin-bottom: 1rem;">
                                    <img src="{{ asset($settings['site_logo']) }}" style="max-height: 60px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.05));" alt="Logo Preview">
                                </div>
                            @endif
                            <input type="file" name="site_logo" class="form-control" style="border: none; box-shadow: none; background: transparent; padding: 0; font-size: 0.8rem;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Favicon (ICO/PNG)</label>
                        <div style="border: 2px dashed #e2e8f0; border-radius: 16px; padding: 1.5rem; text-align: center; background: #fff; min-height: 180px; display: flex; flex-direction: column; justify-content: center;">
                            @if(isset($settings['site_favicon']))
                                <div style="margin-bottom: 1rem;">
                                    <img src="{{ asset($settings['site_favicon']) }}" style="height: 32px; width: 32px;" alt="Favicon Preview">
                                </div>
                            @endif
                            <input type="file" name="site_favicon" class="form-control" style="border: none; box-shadow: none; background: transparent; padding: 0; font-size: 0.8rem;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Management -->
            <div class="card" style="padding: 2rem; border-radius: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); display: flex; align-items: center; justify-content: center; color: #10b981;">
                            <i class="fas fa-compass" style="font-size: 1.25rem;"></i>
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700;">Navigation Menu</h3>
                            <p style="margin:0; font-size: 0.85rem; color: var(--text-muted);">Header links management</p>
                        </div>
                    </div>
                    <button type="button" onclick="addMenu()" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 10px;">
                        <i class="fas fa-plus"></i> Add Item
                    </button>
                </div>

                <div id="menu-container" style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @php $menu = json_decode($settings['main_menu'] ?? '[]', true); @endphp
                    @forelse($menu as $index => $item)
                    <div class="menu-row" style="display: grid; grid-template-columns: 1fr 1fr 40px; gap: 0.75rem; align-items: center; background: #fcfdfe; padding: 0.75rem; border-radius: 12px; border: 1px solid var(--border-soft);">
                        <input type="text" name="menu_label[]" placeholder="Label" class="form-control" value="{{ $item['label'] }}" style="padding: 0.6rem 1rem; font-size: 0.9rem;">
                        <input type="text" name="menu_url[]" placeholder="URL (# for placeholder)" class="form-control" value="{{ $item['url'] }}" style="padding: 0.6rem 1rem; font-size: 0.9rem;">
                        <button type="button" onclick="this.parentElement.remove()" class="btn btn-secondary" style="width: 40px; height: 40px; border-radius: 8px; justify-content: center; color: #ef4444; border-color: rgba(239, 68, 68, 0.1); padding: 0;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @empty
                    <p id="menu-empty" style="text-align: center; color: var(--text-muted); padding: 2rem; background: #f8fafc; border-radius: 12px; border: 1px dashed var(--border-base);">No navigation items set.</p>
                    @endforelse
                </div>
            </div>

            <!-- Footer Quick Links -->
            <div class="card" style="padding: 2rem; border-radius: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); display: flex; align-items: center; justify-content: center; color: #f59e0b;">
                            <i class="fas fa-link" style="font-size: 1.25rem;"></i>
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700;">Footer Links</h3>
                            <p style="margin:0; font-size: 0.85rem; color: var(--text-muted);">Quick navigation links</p>
                        </div>
                    </div>
                    <button type="button" onclick="addFooterLink('quick')" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 10px;">
                        <i class="fas fa-plus"></i> Add Item
                    </button>
                </div>

                <div id="quick-links-container" style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @php $quickLinks = json_decode($settings['footer_quick_links'] ?? '[]', true); @endphp
                    @foreach($quickLinks as $link)
                    <div style="display: grid; grid-template-columns: 1fr 1fr 40px; gap: 0.75rem; align-items: center; background: #fcfdfe; padding: 0.75rem; border-radius: 12px; border: 1px solid var(--border-soft);">
                        <input type="text" name="footer_quick_label[]" placeholder="Label" class="form-control" value="{{ $link['label'] }}" style="padding: 0.6rem 1rem; font-size: 0.9rem;">
                        <input type="text" name="footer_quick_url[]" placeholder="URL" class="form-control" value="{{ $link['url'] }}" style="padding: 0.6rem 1rem; font-size: 0.9rem;">
                        <button type="button" onclick="this.parentElement.remove()" class="btn btn-secondary" style="width: 40px; height: 40px; border-radius: 8px; justify-content: center; color: #ef4444; border-color: rgba(239, 68, 68, 0.1); padding: 0;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            
            <!-- Contact & Social -->
            <div class="card" style="padding: 2rem; border-radius: 20px;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(99, 102, 241, 0.1); display: flex; align-items: center; justify-content: center; color: #6366f1;">
                        <i class="fas fa-address-book" style="font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700;">Contact & Communication</h3>
                        <p style="margin:0; font-size: 0.85rem; color: var(--text-muted);">How users can reach you</p>
                    </div>
                </div>

                <div class="form-group">
                    <label>Support Email</label>
                    <input type="email" name="site_email" class="form-control" value="{{ $settings['site_email'] ?? '' }}" placeholder="e.g. hello@trackgo.com">
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="site_phone" class="form-control" value="{{ $settings['site_phone'] ?? '' }}" placeholder="e.g. +1 555 000 000">
                </div>

                <div class="form-group">
                    <label>Office Address</label>
                    <textarea name="site_address" class="form-control" rows="2" placeholder="Street, City, Country">{{ $settings['site_address'] ?? '' }}</textarea>
                </div>

                <hr style="border: 0; border-top: 1px solid var(--border-soft); margin: 2rem 0;">

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                    <h4 style="margin: 0; font-size: 1rem; font-weight: 700;">Social Media Links</h4>
                    <button type="button" onclick="addSocial()" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; border-radius: 8px;">
                        <i class="fas fa-plus"></i> Connect
                    </button>
                </div>

                <div id="social-container" style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @php $socials = json_decode($settings['social_links'] ?? '[]', true); @endphp
                    @foreach($socials as $social)
                    <div style="display: grid; grid-template-columns: 100px 1fr 40px; gap: 0.75rem; align-items: center; background: #fff; padding: 0.5rem; border-radius: 10px; border: 1px solid var(--border-soft);">
                        <select name="social_platform[]" class="form-control" style="padding: 0.4rem; font-size: 0.85rem; height: 38px;">
                            <option value="Facebook" {{ $social['platform'] == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                            <option value="Twitter" {{ $social['platform'] == 'Twitter' ? 'selected' : '' }}>Twitter</option>
                            <option value="Instagram" {{ $social['platform'] == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                            <option value="LinkedIn" {{ $social['platform'] == 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option>
                            <option value="Youtube" {{ $social['platform'] == 'Youtube' ? 'selected' : '' }}>Youtube</option>
                        </select>
                        <input type="text" name="social_url[]" placeholder="Profile URL" class="form-control" value="{{ $social['url'] }}" style="padding: 0.4rem 0.75rem; font-size: 0.85rem; height: 38px;">
                        <button type="button" onclick="this.parentElement.remove()" class="btn btn-secondary" style="width: 38px; height: 38px; border-radius: 8px; justify-content: center; padding: 0;">
                            <i class="fas fa-trash-can" style="font-size: 0.8rem; color: #ef4444;"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Content Overrides -->
            <div class="card" style="padding: 2rem; border-radius: 20px;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(139, 92, 246, 0.1); display: flex; align-items: center; justify-content: center; color: #8b5cf6;">
                        <i class="fas fa-pencil-square" style="font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700;">Global Content</h3>
                        <p style="margin:0; font-size: 0.85rem; color: var(--text-muted);">Manage site-wide text areas</p>
                    </div>
                </div>

                <div class="form-group">
                    <label>Footer Elevator Pitch</label>
                    <textarea name="site_footer_about" class="form-control" rows="3" placeholder="Brief pitch for your business...">{{ $settings['site_footer_about'] ?? '' }}</textarea>
                </div>

                <div class="form-group">
                    <label>Contact Page Map Embed (Iframe Code)</label>
                    <textarea name="site_contact_map" class="form-control" rows="4" placeholder="Paste Google Maps iframe code here...">{{ $settings['site_contact_map'] ?? '' }}</textarea>
                </div>

                <div style="padding: 1rem; background: #fff9f0; border-radius: 12px; border: 1px solid #ffeeba; display: flex; gap: 1rem;">
                    <i class="fas fa-circle-info" style="color: #f59e0b; margin-top: 0.2rem;"></i>
                    <p style="margin: 0; font-size: 0.85rem; color: #856404; line-height: 1.5;">Some specific page contents like the "Our Narrative" section of the About Us page can also be edited directly in the Page Builder.</p>
                </div>
            </div>

        </div>

    </div>

    <!-- Final Save Action -->
    <div style="margin-top: 4rem; padding: 2rem; background: #fff; border-radius: 24px; border: 1px solid var(--border-soft); display: flex; justify-content: space-between; align-items: center; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05);">
        <div>
            <h4 style="margin: 0; font-size: 1.15rem; font-weight: 800;">Ready to apply changes?</h4>
            <p style="margin: 0.25rem 0 0; color: var(--text-muted); font-size: 0.9rem;">Remember to double-check color values before saving.</p>
        </div>
        <button type="submit" class="btn btn-primary" style="padding: 1rem 3.5rem; font-size: 1.1rem; border-radius: 14px;">
            <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> Deploy All Settings
        </button>
    </div>
</form>

<script>
function addSocial() {
    const container = document.getElementById('social-container');
    const div = document.createElement('div');
    div.style.display = 'grid';
    div.style.gridTemplateColumns = '100px 1fr 40px';
    div.style.gap = '0.75rem';
    div.style.alignItems = 'center';
    div.style.background = '#fff';
    div.style.padding = '0.5rem';
    div.style.borderRadius = '10px';
    div.style.border = '1px solid var(--border-soft)';
    
    div.innerHTML = `
        <select name="social_platform[]" class="form-control" style="padding: 0.4rem; font-size: 0.85rem; height: 38px;">
            <option value="Facebook">Facebook</option>
            <option value="Twitter">Twitter</option>
            <option value="Instagram">Instagram</option>
            <option value="LinkedIn">LinkedIn</option>
            <option value="Youtube">Youtube</option>
        </select>
        <input type="text" name="social_url[]" placeholder="Profile URL" class="form-control" style="padding: 0.4rem 0.75rem; font-size: 0.85rem; height: 38px;">
        <button type="button" onclick="this.parentElement.remove()" class="btn btn-secondary" style="width: 38px; height: 38px; border-radius: 8px; justify-content: center; padding: 0;">
            <i class="fas fa-trash-can" style="font-size: 0.8rem; color: #ef4444;"></i>
        </button>
    `;
    container.appendChild(div);
}

function addMenu() {
    const empty = document.getElementById('menu-empty');
    if(empty) empty.remove();
    
    const container = document.getElementById('menu-container');
    const div = document.createElement('div');
    div.className = 'menu-row';
    div.style.display = 'grid';
    div.style.gridTemplateColumns = '1fr 1fr 40px';
    div.style.gap = '0.75rem';
    div.style.alignItems = 'center';
    div.style.background = '#fcfdfe';
    div.style.padding = '0.75rem';
    div.style.borderRadius = '12px';
    div.style.border = '1px solid var(--border-soft)';
    
    div.innerHTML = `
        <input type="text" name="menu_label[]" placeholder="Label" class="form-control" style="padding: 0.6rem 1rem; font-size: 0.9rem;">
        <input type="text" name="menu_url[]" placeholder="URL" class="form-control" style="padding: 0.6rem 1rem; font-size: 0.9rem;">
        <button type="button" onclick="this.parentElement.remove()" class="btn btn-secondary" style="width: 40px; height: 40px; border-radius: 8px; justify-content: center; color: #ef4444; border-color: rgba(239, 68, 68, 0.1); padding: 0;">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}

function addFooterLink(type) {
    const container = document.getElementById(`${type}-links-container`);
    const div = document.createElement('div');
    div.style.display = 'grid';
    div.style.gridTemplateColumns = '1fr 1fr 40px';
    div.style.gap = '0.75rem';
    div.style.alignItems = 'center';
    div.style.background = '#fcfdfe';
    div.style.padding = '0.75rem';
    div.style.borderRadius = '12px';
    div.style.border = '1px solid var(--border-soft)';
    
    div.innerHTML = `
        <input type="text" name="footer_${type}_label[]" placeholder="Label" class="form-control" style="padding: 0.6rem 1rem; font-size: 0.9rem;">
        <input type="text" name="footer_${type}_url[]" placeholder="URL" class="form-control" style="padding: 0.6rem 1rem; font-size: 0.9rem;">
        <button type="button" onclick="this.parentElement.remove()" class="btn btn-secondary" style="width: 40px; height: 40px; border-radius: 8px; justify-content: center; color: #ef4444; border-color: rgba(239, 68, 68, 0.1); padding: 0;">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}
</script>
@endsection
