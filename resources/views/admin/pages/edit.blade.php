@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Edit Page</h1>
        <p style="color: var(--text-muted);">Refine your custom structure and content.</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="btn btn-secondary" style="border-radius: 20px; font-size: 0.8rem;">
            <i class="fas fa-external-link-alt"></i> View Live
        </a>
        <button form="page-form" type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem;">
            <i class="fas fa-save"></i> Update Page
        </button>
    </div>
</div>

<form id="page-form" action="{{ route('admin.pages.update', $page->id) }}" method="POST">
    @csrf
    @method('PUT')
    

    <!-- Row 1: Section Builder (Full Width) -->
    <div class="card" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-size: 1.1rem; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Section Builder</h2>
                <p style="font-size: 0.75rem; color: var(--text-light); margin: 0.25rem 0 0;">Add and arrange any block to build your custom structure.</p>
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
        </div>
    </div>

    <!-- Row 2: SEO and Page Details (2 Columns) -->
    <div class="form-row" style="grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- SEO Card -->
        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem;"><i class="fas fa-search" style="color:var(--primary); margin-right: 0.5rem;"></i> SEO Optimization</h3>
            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title" value="{{ $page->meta_title }}" class="form-control" placeholder="SEO Title">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ $page->meta_keywords }}" class="form-control" placeholder="keyword1, keyword2...">
                </div>
            </div>
            <div class="form-group mb-0">
                <label>Meta Description</label>
                <textarea name="meta_description" rows="3" class="form-control" placeholder="Brief summary for search engines...">{{ $page->meta_description }}</textarea>
            </div>
        </div>

        <!-- Page Details Card -->
        <div class="card">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Page Details</h2>
            
            <div class="form-group">
                <label>Page Title</label>
                <input type="text" name="title" class="form-control" value="{{ $page->title }}" required>
            </div>
            
            <div class="form-group">
                <label>URL Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ $page->slug }}">
            </div>

            <div class="form-group mb-0">
                <label>Banner Image</label>
                <div style="display: flex; gap: 1rem; align-items: end;">
                    <div style="flex: 1;">
                        <input type="url" name="hero_image" id="hero_image" class="form-control" value="{{ $page->thumbnail }}" placeholder="https://... or upload below">
                    </div>
                    <div>
                        <input type="file" name="banner_upload" id="banner_upload" accept="image/*" style="display: none;" onchange="uploadBannerImage(this)">
                        <button type="button" onclick="document.getElementById('banner_upload').click()" class="btn btn-secondary" style="white-space: nowrap;">
                            <i class="fas fa-upload"></i> Upload
                        </button>
                    </div>
                </div>
                <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 0.5rem; display: block;">
                    Upload an image or enter a URL. Recommended size: 1200x250px for best results.
                </small>
                @if($page->thumbnail)
                    <div style="margin-top: 1rem;">
                        <img src="{{ $page->thumbnail }}" alt="Current banner" style="max-width: 200px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border);">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <input type="hidden" name="blocks" id="blocks-input">
</form>

<!-- Settings Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: var(--shadow-lg);">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-soft); padding: 1.5rem 2rem;">
                <h5 class="modal-title" style="font-weight: 700; color: var(--text-main);">Block Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem; max-height: 60vh; overflow-y: auto;">
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

<style>
/* Fix modal positioning and scrolling issues */
.modal {
    z-index: 1055 !important;
}

.modal-backdrop {
    z-index: 1050 !important;
}

.modal-dialog-centered {
    display: flex;
    align-items: center;
    min-height: calc(100% - 1rem);
}

.modal-body {
    position: relative;
}

/* Prevent body scroll when modal is open */
body.modal-open {
    overflow: hidden !important;
    padding-right: 0 !important;
}

/* Fix form styling in modal */
.modal .form-row {
    display: grid;
    margin-bottom: 1rem;
}

.modal .form-group {
    margin-bottom: 1rem;
}

.modal .form-group label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text-main);
    display: block;
}

.modal .form-control {
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 0.75rem;
    font-size: 0.9rem;
}

.modal .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.25);
}

/* Column management buttons */
.btn-icon-xs {
    width: 24px;
    height: 24px;
    border: none;
    background: var(--bg-main);
    color: var(--text-muted);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-icon-xs:hover {
    background: var(--primary);
    color: white;
    transform: scale(1.1);
}

.column-wrapper {
    transition: all 0.3s ease;
}

.column-wrapper:hover {
    border-color: var(--primary);
    background: rgba(var(--primary-rgb), 0.02);
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.85rem;
    border-radius: 8px;
}

.btn-outline-secondary {
    border: 1px solid var(--border);
    background: transparent;
    color: var(--text-muted);
}

.btn-outline-secondary:hover {
    background: var(--bg-main);
    border-color: var(--primary);
    color: var(--primary);
}
</style>

<script>
    // Initialize blocks with proper error handling
    let blocks = [];
    try {
        const pageContent = @json($page->content ?? []);
        blocks = Array.isArray(pageContent) ? pageContent : [];
        console.log('Loaded blocks:', blocks);
    } catch (error) {
        console.error('Error loading page content:', error);
        blocks = [];
    }
    
    // Ensure blocks is available globally
    window.blocks = blocks;
    
    // Initialize the page builder when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.renderBlocks === 'function') {
            window.renderBlocks();
        } else {
            console.warn('renderBlocks function not available yet');
        }
    });
</script>
@include('admin.pages.script')
<script>
    renderBlocks();
</script>
@endsection
