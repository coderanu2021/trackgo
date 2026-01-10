@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Edit Page: {{ $page->title }}</h1>
        <p style="color: var(--text-muted);">Manage your custom page content and SEO.</p>
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
    
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <div style="display: grid; gap: 1.5rem; align-content: start;">
            <!-- Block Editor -->
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 600; margin: 0;">Content Blocks</h2>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <button type="button" onclick="addBlock('text')" class="btn btn-secondary" style="font-size: 0.75rem; padding: 0.4rem 0.8rem;">+ Text</button>
                        <button type="button" onclick="addBlock('image')" class="btn btn-secondary" style="font-size: 0.75rem; padding: 0.4rem 0.8rem;">+ Image</button>
                        <button type="button" onclick="addBlock('button')" class="btn btn-secondary" style="font-size: 0.75rem; padding: 0.4rem 0.8rem;">+ Button</button>
                    </div>
                </div>

                <div id="blocks-container" style="display: flex; flex-direction: column; gap: 1rem;">
                    <p id="empty-state" style="text-align: center; color: var(--text-light); padding: 3rem; border: 2px dashed var(--border); border-radius: var(--radius-md); display: none;">
                        <i class="fas fa-cubes" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.3;"></i><br>
                        No content blocks added yet.
                    </p>
                </div>
            </div>

            <div class="card">
                <h3 style="margin-top: 0; margin-bottom: 1.5rem;"><i class="fas fa-search" style="color:var(--primary)"></i> SEO Optimization</h3>
                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ $page->meta_title }}" class="form-control" placeholder="SEO Title">
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ $page->meta_keywords }}" class="form-control" placeholder="keyword1, keyword2...">
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control" placeholder="Brief summary for search engines...">{{ $page->meta_description }}</textarea>
                </div>
            </div>
        </div>

        <div style="display: grid; gap: 1.5rem; align-content: start;">
            <div class="card">
                <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1.5rem;">Page Details</h2>
                
                <div class="form-group">
                    <label class="form-label">Page Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $page->title }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">URL Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ $page->slug }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Hero Image URL</label>
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
