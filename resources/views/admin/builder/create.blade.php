@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Create Landing Page</h1>
        <p style="color: var(--text-muted);">Build a dynamic landing page with a structure of your own choice.</p>
    </div>
    <button form="page-form" type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem;">
        <i class="fas fa-paper-plane"></i> Publish Page
    </button>
</div>

<form id="page-form" action="{{ route('admin.builder.store') }}" method="POST">
    @csrf
    

    <!-- Row 1: Section Builder (Full Width) -->
    <div class="card" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-size: 1.1rem; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Section Builder</h2>
                <p style="font-size: 0.75rem; color: var(--text-light); margin: 0.25rem 0 0;">Add and arrange any block to build your custom structure.</p>
            </div>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
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
            <p id="empty-state" style="text-align: center; color: var(--text-light); padding: 4rem 2rem; border: 2px dashed var(--border-soft); border-radius: var(--radius-lg); background: var(--bg-main);">
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
                <input type="text" name="meta_title" class="form-control" placeholder="SEO Title">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control" placeholder="keyword1, keyword2...">
                </div>
            </div>
            <div class="form-group mb-0">
                <label>Meta Description</label>
                <textarea name="meta_description" rows="3" class="form-control" placeholder="Brief summary for search engines..."></textarea>
            </div>
        </div>

        <!-- Page Details Card -->
        <div class="card">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Page Details</h2>
            
            <div class="form-group">
                <label>Page Title</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. Summer Collection" required>
            </div>
            
            <div class="form-group">
                <label>URL Slug (Optional)</label>
                <input type="text" name="slug" class="form-control" placeholder="summer-collection">
            </div>

            <div class="form-group mb-0">
                <label>Hero Image URL</label>
                <input type="url" name="hero_image" class="form-control" placeholder="https://...">
            </div>
        </div>
    </div>

    <input type="hidden" name="blocks" id="blocks-input">
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
                <div class="form-group">
                    <label>Background Color</label>
                    <input type="color" id="set-bg-color" class="form-control" style="height: 50px; padding: 5px;">
                </div>
                <div class="form-group">
                    <label>Text Color</label>
                    <input type="color" id="set-text-color" class="form-control" style="height: 50px; padding: 5px;">
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
</script>
@include('admin.builder.script')
<script>
    renderBlocks();
</script>
@endsection
