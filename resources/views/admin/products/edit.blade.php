@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Edit Product Page</h1>
        <p style="color: var(--text-muted);">Refine your product page content and structure.</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('products.show', $page->slug) }}" target="_blank" class="btn btn-secondary" style="border-radius: 20px; font-size: 0.8rem;">
            <i class="fas fa-eye"></i> Preview
        </a>
        <button form="page-form" type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem;">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </div>
</div>

<form id="page-form" action="{{ route('admin.products.update', $page->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-row" style="grid-template-columns: 2fr 1fr;">
        <div class="flex flex-col gap-4">
            <!-- Block Editor -->
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <div>
                        <h2 style="font-size: 1.1rem; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Content Designer</h2>
                        <p style="font-size: 0.75rem; color: var(--text-light); margin: 0.25rem 0 0;">Select and arrange sections to design your page.</p>
                    </div>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <button type="button" onclick="addBlock('columns')" class="btn btn-secondary" title="Add Multi-Column Layout">
                    <i class="fas fa-columns"></i> Columns
                </button>
                <div style="border-left: 1px solid var(--border-soft); margin: 0 0.5rem;"></div>
                <button type="button" onclick="addBlock('text')" class="btn btn-secondary" title="Add Text Area">
                    <i class="fas fa-font"></i> Text
                </button>
                <button type="button" onclick="addBlock('image')" class="btn btn-secondary" title="Add Image">
                    <i class="fas fa-image"></i> Image
                </button>
                <button type="button" onclick="addBlock('button')" class="btn btn-secondary" title="Add Call to Action">
                    <i class="fas fa-link"></i> Button
                </button>
                <div style="border-left: 1px solid var(--border-soft); margin: 0 0.5rem;"></div>
                <button type="button" onclick="addBlock('hero_stats')" class="btn btn-secondary" title="Add Hero with Stats">
                    <i class="fas fa-chart-line"></i> Hero Stats
                </button>
                <button type="button" onclick="addBlock('timeline')" class="btn btn-secondary" title="Add Timeline">
                    <i class="fas fa-clock-rotate-left"></i> Timeline
                </button>
                <button type="button" onclick="addBlock('split_content')" class="btn btn-secondary" title="Add Media & Text Split">
                    <i class="fas fa-columns"></i> Split Content
                </button>
                <button type="button" onclick="addBlock('features')" class="btn btn-secondary" title="Add Feature Grid">
                    <i class="fas fa-list-check"></i> Features
                </button>
                <button type="button" onclick="addBlock('tabs')" class="btn btn-secondary" title="Add Interactive Tabs">
                    <i class="fas fa-folder-tree"></i> Tabs
                </button>
            </div>
        </div>

        <div id="blocks-container" style="display: flex; flex-direction: column; gap: 1.5rem;">
            <p id="empty-state" style="text-align: center; color: var(--text-light); padding: 4rem 2rem; border: 2px dashed var(--border-soft); border-radius: var(--radius-lg); background: var(--bg-main); display: none;">
                <i class="fas fa-cubes" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.2;"></i><br>
                <span style="font-size: 0.95rem; font-weight: 500;">No content blocks added yet. Start building your page!</span>
            </p>
             <!-- Blocks will be rendered here by JavaScript -->
        </div>
    </div>

    <div class="card">
        <h3 style="margin-top: 0; margin-bottom: 1.5rem;"><i class="fas fa-search" style="color:var(--primary); margin-right: 0.5rem;"></i> SEO Meta Data</h3>
        <div class="form-group">
            <label>Meta Title</label>
            <input type="text" name="meta_title" class="form-control" value="{{ $page->meta_title }}" placeholder="SEO Page Title">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Meta Keywords</label>
                <input type="text" name="meta_keywords" class="form-control" value="{{ $page->meta_keywords }}" placeholder="e.g. tracking, logistics, about us">
            </div>
        </div>
        <div class="form-group mb-0">
            <label>Meta Description</label>
            <textarea name="meta_description" rows="3" class="form-control" placeholder="A short summary of the page for search engines...">{{ $page->meta_description }}</textarea>
        </div>
    </div>
</div>

<div class="flex flex-col gap-4">
    <!-- Product Media Card -->
    <div class="card">
        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Media Assets</h2>
        
        <div class="form-group">
            <label>Main Product Image (Thumbnail)</label>
            <div class="flex gap-2">
                <input type="url" name="thumbnail" id="thumbnail-input" class="form-control" value="{{ $page->thumbnail }}" placeholder="https://...">
                <label class="btn btn-secondary" style="margin:0; cursor:pointer; padding:0 1rem; height:48px; display:flex; align-items:center; border-radius:12px;">
                    <i class="fas fa-upload"></i> <input type="file" onchange="uploadMainImage(this)" accept="image/*" style="display:none;">
                </label>
            </div>
        </div>

        <div class="form-group">
            <label style="display:flex; justify-content:space-between; align-items:center;">
                Product Gallery
                <button type="button" onclick="addGalleryItem()" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add Image</button>
            </label>
            <div id="gallery-container" class="flex flex-col gap-2 mt-2">
                <!-- Gallery items will be added here -->
            </div>
            <input type="hidden" name="gallery" id="gallery-hidden-input" value="{{ json_encode($page->gallery ?? []) }}">
        </div>

        <hr style="border:0; border-top:1px solid var(--border-soft); margin: 2rem 0;">

        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Product Details</h2>
        
        <div class="form-row" style="grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label>Product Category</label>
                <select name="category_id" class="form-control">
                    <option value="">No Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $page->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="title" class="form-control" value="{{ $page->title }}" placeholder="e.g. Premium Wireless Headphones" required>
            </div>
        </div>
        
        <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label>Regular Price ($)</label>
                <input type="number" name="price" class="form-control" step="0.01" value="{{ $page->price }}" placeholder="e.g. 99.99">
            </div>
            <div class="form-group">
                <label>Discount Amount ($)</label>
                <input type="number" name="discount" class="form-control" step="0.01" value="{{ $page->discount }}" placeholder="e.g. 10.00">
            </div>
            <div class="form-group">
                <label>Stock Count</label>
                <input type="number" name="stock" class="form-control" value="{{ $page->stock }}" placeholder="e.g. 100">
            </div>
        </div>

        <div class="form-group">
            <label>Custom URL Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ $page->slug }}" placeholder="e.g. about-us">
        </div>

        <div class="form-group mb-0">
             <label>Visibility</label>
             <select name="is_active" class="form-control">
                 <option value="1" {{ $page->is_active ? 'selected' : '' }}>Published / Public</option>
                 <option value="0" {{ !$page->is_active ? 'selected' : '' }}>Draft / Private</option>
             </select>
        </div>
    </div>
</div>
</div>

<input type="hidden" name="blocks" id="blocks-input" value="{{ json_encode($page->content) }}">
</form>

<!-- Settings Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content" style="border-radius: 20px; border: none; box-shadow: var(--shadow-lg);">
    <div class="modal-header" style="border-bottom: 1px solid var(--border-soft); padding: 1.5rem 2rem;">
        <h5 class="modal-title" style="font-weight: 700; color: var(--text-main);">Block Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body" style="padding: 2rem;">
        <div class="form-row" style="grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label>Background Color</label>
                <input type="color" id="set-bg-color" class="form-control" style="height: 50px; padding: 5px;">
            </div>
            <div class="form-group">
                <label>Text Color</label>
                <input type="color" id="set-text-color" class="form-control" style="height: 50px; padding: 5px;">
            </div>
        </div>
        <div class="form-row" style="grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label>Padding Top (rem)</label>
                <input type="number" id="set-padding-top" class="form-control" min="0" max="20" step="0.5">
            </div>
            <div class="form-group">
                <label>Padding Bottom (rem)</label>
                <input type="number" id="set-padding-bottom" class="form-control" min="0" max="20" step="0.5">
            </div>
        </div>
        <div class="form-row" style="grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label>Margin Top (rem)</label>
                <input type="number" id="set-margin-top" class="form-control" min="0" max="20" step="0.5">
            </div>
            <div class="form-group">
                <label>Margin Bottom (rem)</label>
                <input type="number" id="set-margin-bottom" class="form-control" min="0" max="20" step="0.5">
            </div>
        </div>
        <div class="form-row" style="grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label>Font Size (px)</label>
                <input type="number" id="set-font-size" class="form-control" min="8" max="100">
            </div>
            <div class="form-group">
                <label>Border Radius (px)</label>
                <input type="number" id="set-border-radius" class="form-control" min="0" max="100">
            </div>
        </div>
    </div>
    <div class="modal-footer" style="border-top: 1px solid var(--border-soft); padding: 1.5rem 2rem;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="saveSettings()">Apply Settings</button>
    </div>
</div>
</div>
</div>

<script>
    // Global data initialization
    window.blocks = {!! json_encode($page->content ?? []) !!};
    if (!Array.isArray(window.blocks)) window.blocks = [];
    window.gallery = {!! json_encode($page->gallery ?? []) !!};
    if (!Array.isArray(window.gallery)) window.gallery = [];

    function addGalleryItem(url = '') {
        window.gallery.push(url);
        renderGallery();
    }

    function removeGalleryItem(index) {
        window.gallery.splice(index, 1);
        renderGallery();
    }

    function updateGalleryItem(index, value) {
        window.gallery[index] = value;
        document.getElementById('gallery-hidden-input').value = JSON.stringify(window.gallery);
    }

    function renderGallery() {
        const container = document.getElementById('gallery-container');
        if (!container) return;
        container.innerHTML = '';
        window.gallery.forEach((url, index) => {
            const div = document.createElement('div');
            div.className = 'flex gap-2';
            div.innerHTML = `
                <input type="url" class="form-control" value="${url}" onchange="updateGalleryItem(${index}, this.value)" placeholder="Image URL">
                <label class="btn btn-secondary" style="margin:0; cursor:pointer; padding:0 1rem; height:48px; display:flex; align-items:center; border-radius:12px;">
                    <i class="fas fa-upload"></i> <input type="file" onchange="uploadGalleryImage(this, ${index})" accept="image/*" style="display:none;">
                </label>
                <button type="button" onclick="removeGalleryItem(${index})" class="btn btn-secondary" style="color:#ef4444;"><i class="fas fa-trash"></i></button>
            `;
            container.appendChild(div);
        });
        document.getElementById('gallery-hidden-input').value = JSON.stringify(window.gallery);
    }

    async function uploadMainImage(input) {
        const file = input.files[0];
        if (!file) return;
        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');
        try {
            const res = await fetch('{{ route('admin.pages.upload') }}', { method: 'POST', body: formData });
            const data = await res.json();
            if (data.url) document.getElementById('thumbnail-input').value = data.url;
        } catch(e) { console.error(e); alert('Upload failed'); }
    }

    async function uploadGalleryImage(input, index) {
        const file = input.files[0];
        if (!file) return;
        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');
        try {
            const res = await fetch('{{ route('admin.pages.upload') }}', { method: 'POST', body: formData });
            const data = await res.json();
            if (data.url) {
                window.gallery[index] = data.url;
                renderGallery();
            }
        } catch(e) { console.error(e); alert('Upload failed'); }
    }

    document.addEventListener('DOMContentLoaded', function() {
        renderGallery();
        if (typeof window.renderBlocks === 'function') {
            window.renderBlocks();
        }
    });
</script>

@include('admin.pages.script')
@endsection
