@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Edit Landing Page</h1>
        <p style="color: var(--text-muted);">Refine your custom structure and content.</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('projects.show', $page->slug) }}" target="_blank" class="btn btn-secondary" style="border-radius: 20px; font-size: 0.8rem;">
            <i class="fas fa-external-link-alt"></i> View Live
        </a>
        <button form="page-form" type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem;">
            <i class="fas fa-save"></i> Update Page
        </button>
    </div>
</div>

<form id="page-form" action="{{ route('admin.builder.update', $page->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-row" style="grid-template-columns: 2fr 1fr;">
        <div class="flex flex-col gap-4">
            <!-- Block Editor -->
            <div class="card">
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
                    <p id="empty-state" style="text-align: center; color: var(--text-light); padding: 4rem 2rem; border: 2px dashed var(--border-soft); border-radius: var(--radius-lg); background: var(--bg-main); display: none;">
                        <i class="fas fa-cubes" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.2;"></i><br>
                        <span style="font-size: 0.95rem; font-weight: 500;">No content blocks added yet. Start building your page!</span>
                    </p>
                </div>
            </div>

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
        </div>

        <div class="flex flex-col gap-4">
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
                    <label>Hero Image URL</label>
                    <input type="url" name="hero_image" class="form-control" value="{{ $page->hero_image }}">
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="blocks" id="blocks-input">
</form>

<script>
    let blocks = @json($page->content ?? []);
</script>
@include('admin.builder.script')
<script>
    renderBlocks();
</script>
@endsection
