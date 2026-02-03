@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Product Page Builder</h1>
        <p style="color: var(--text-muted);">Design custom product detail pages with drag-and-drop sections.</p>
    </div>
    <button form="page-form" type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem;">
        <i class="fas fa-check"></i> Save Product Page
    </button>
</div>

<form id="page-form" action="{{ route('admin.products.store') }}" method="POST">
    @csrf
    
    @if($errors->any())
        <div class="alert alert-danger" style="background: #fef2f2; border: 1px solid #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    

    <!-- Row 1: Content Designer (Full Width) -->
    <div class="card" style="margin-bottom: 2rem;">
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
                <button type="button" onclick="addBlock('table')" class="btn btn-secondary" title="Add Table">
                    <i class="fas fa-table"></i> Table
                </button>
            </div>
        </div>

        <div id="blocks-container" style="display: flex; flex-direction: column; gap: 1.5rem;">
            <p id="empty-state" style="text-align: center; color: var(--text-light); padding: 4rem 2rem; border: 2px dashed var(--border-soft); border-radius: var(--radius-lg); background: var(--bg-main);">
                <i class="fas fa-layer-group" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.2;"></i><br>
                <span style="font-size: 0.95rem; font-weight: 500;">No sections added yet. Click a button above to start!</span>
            </p>
        </div>
    </div>

    <!-- Row 2: SEO and Settings (2 Columns) -->
    <div class="form-row" style="grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- SEO Card -->
        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem;"><i class="fas fa-search" style="color:var(--primary); margin-right: 0.5rem;"></i> SEO Meta Data</h3>
            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title" class="form-control" placeholder="SEO Page Title">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control" placeholder="e.g. tracking, logistics, about us">
                </div>
            </div>
            <div class="form-group mb-0">
                <label>Meta Description</label>
                <textarea name="meta_description" rows="3" class="form-control" placeholder="A short summary of the page for search engines..."></textarea>
            </div>
        </div>

        <!-- Product Media Card -->
        <div class="card">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Media Assets</h2>
            
            <div class="form-group">
                <label>Main Product Image (Thumbnail)</label>
                <div class="flex gap-2">
                    <input type="url" name="hero_image" id="thumbnail-input" class="form-control" placeholder="https://...">
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
                <input type="hidden" name="gallery" id="gallery-hidden-input" value="[]">
            </div>

            <hr style="border:0; border-top:1px solid var(--border-soft); margin: 2rem 0;">

            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Product Details</h2>
            
            <div class="form-row" style="grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Primary Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">No Primary Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Premium Wireless Headphones" required>
                </div>
            </div>

            <div class="form-group">
                <label>Additional Categories</label>
                <div style="max-height: 200px; overflow-y: auto; border: 1px solid var(--border); border-radius: 8px; padding: 1rem; background: var(--bg-light);">
                    @foreach($categories as $category)
                        <div style="margin-bottom: 0.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: normal; cursor: pointer;">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" style="margin: 0;">
                                <span>{{ $category->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
                <small style="color: var(--text-light);">Select multiple categories for this product (optional)</small>
            </div>
            
            <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Selling Price (₹)</label>
                    <small class="form-text text-muted">Current price customers will pay</small>
                    <input type="number" name="price" class="form-control" step="0.01" placeholder="e.g. 12500.00">
                </div>
                <div class="form-group">
                    <label>Discount Amount (₹)</label>
                    <small class="form-text text-muted">Amount off from original price (shows strikethrough)</small>
                    <input type="number" name="discount" class="form-control" step="0.01" placeholder="e.g. 2500.00">
                </div>
                <div class="form-group">
                    <label>Stock Count</label>
                    <input type="number" name="stock" class="form-control" placeholder="e.g. 100">
                </div>
            </div>

            <!-- Price Preview -->
            <div class="form-group">
                <label>Price Display Preview</label>
                <div class="price-preview" style="padding: 1rem; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef;">
                    <div style="font-size: 1.1rem; margin-bottom: 0.5rem;">
                        <span style="color: #6c757d;">Customer will see:</span>
                    </div>
                    <div id="price-display-preview" style="font-size: 1.3rem;">
                        <span id="original-price" style="color: #ef4444; text-decoration: line-through; margin-right: 0.5rem; display: none;">₹0.00</span>
                        <span id="selling-price" style="color: var(--primary); font-weight: 700;">₹0.00</span>
                    </div>
                    <small class="text-muted">Enter prices above to see preview</small>
                </div>
            </div>

            <div class="form-group">
                <label>Custom URL Slug</label>
                <input type="text" name="slug" class="form-control" placeholder="e.g. about-us">
                <small style="color: var(--text-light);">Leave blank to generate from product name.</small>
            </div>

            <div class="form-group mb-0">
                 <label>Visibility</label>
                 <select name="is_active" class="form-control">
                     <option value="1">Published / Public</option>
                     <option value="0">Draft / Private</option>
                 </select>
            </div>
        </div>
    </div>

    <input type="hidden" name="blocks" id="blocks-input" value="[]">
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
    let blocks = [];
    let gallery = [];

    function addGalleryItem(url = '') {
        const index = gallery.length;
        gallery.push(url);
        renderGallery();
    }

    function removeGalleryItem(index) {
        gallery.splice(index, 1);
        renderGallery();
    }

    function updateGalleryItem(index, value) {
        gallery[index] = value;
        document.getElementById('gallery-hidden-input').value = JSON.stringify(gallery);
    }

    function renderGallery() {
        const container = document.getElementById('gallery-container');
        container.innerHTML = '';
        gallery.forEach((url, index) => {
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
        document.getElementById('gallery-hidden-input').value = JSON.stringify(gallery);
    }

    async function uploadMainImage(input) {
        const file = input.files[0];
        if (!file) return;
        
        console.log('Starting upload for file:', file.name, 'Size:', file.size, 'Type:', file.type);
        
        // Show loading state
        const thumbnailInput = document.getElementById('thumbnail-input');
        const originalValue = thumbnailInput.value;
        thumbnailInput.value = 'Uploading...';
        thumbnailInput.disabled = true;
        
        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');
        
        try {
            console.log('Sending upload request to:', '{{ route('admin.pages.upload') }}');
            const res = await fetch('{{ route('admin.pages.upload') }}', { method: 'POST', body: formData });
            console.log('Response status:', res.status);
            
            const data = await res.json();
            console.log('Response data:', data);
            
            if (data.url) {
                thumbnailInput.value = data.url;
                console.log('Image uploaded successfully:', data.url);
                alert('Image uploaded successfully!');
            } else {
                throw new Error(data.error || 'Upload failed');
            }
        } catch(e) { 
            console.error('Upload error:', e); 
            alert('Upload failed: ' + e.message);
            thumbnailInput.value = originalValue;
        } finally {
            thumbnailInput.disabled = false;
        }
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
                gallery[index] = data.url;
                renderGallery();
                console.log('Gallery image uploaded successfully:', data.url);
            } else {
                throw new Error(data.error || 'Upload failed');
            }
        } catch(e) { 
            console.error('Gallery upload error:', e); 
            alert('Gallery upload failed: ' + e.message);
        }
    }
</script>

<script>
// Price Preview Functionality
function updatePricePreview() {
    const sellingPrice = parseFloat(document.querySelector('input[name="price"]').value) || 0;
    const discountAmount = parseFloat(document.querySelector('input[name="discount"]').value) || 0;
    const originalPrice = sellingPrice + discountAmount;
    
    const originalPriceEl = document.getElementById('original-price');
    const sellingPriceEl = document.getElementById('selling-price');
    
    // Format prices in Indian format
    const formatIndianPrice = (amount) => {
        return new Intl.NumberFormat('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount);
    };
    
    if (discountAmount > 0) {
        originalPriceEl.textContent = '₹' + formatIndianPrice(originalPrice);
        originalPriceEl.style.display = 'inline';
    } else {
        originalPriceEl.style.display = 'none';
    }
    
    sellingPriceEl.textContent = '₹' + formatIndianPrice(sellingPrice);
}

// Add event listeners
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.querySelector('input[name="price"]');
    const discountInput = document.querySelector('input[name="discount"]');
    
    if (priceInput) priceInput.addEventListener('input', updatePricePreview);
    if (discountInput) discountInput.addEventListener('input', updatePricePreview);
    
    // Initial update
    updatePricePreview();
});
</script>
@include('admin.pages.script')
<script>
    renderBlocks();
</script>
@endsection
