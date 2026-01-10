@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Create Page</h1>
        <p style="color: var(--text-muted);">Build a dynamic landing page with ease.</p>
    </div>
    <button form="page-form" type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem;">
        <i class="fas fa-paper-plane"></i> Publish Page
    </button>
</div>

<form id="page-form" action="{{ route('admin.builder.store') }}" method="POST">
    @csrf
    
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
                    <p id="empty-state" style="text-align: center; color: var(--text-light); padding: 3rem; border: 2px dashed var(--border); border-radius: var(--radius-md);">
                        <i class="fas fa-cubes" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.3;"></i><br>
                        No content blocks added yet. Start building your page!
                    </p>
                </div>
            </div>

            <div class="card">
                <h3 style="margin-top: 0; margin-bottom: 1.5rem;"><i class="fas fa-search" style="color:var(--primary)"></i> SEO Optimization</h3>
                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" placeholder="SEO Title">
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control" placeholder="keyword1, keyword2...">
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control" placeholder="Brief summary for search engines..."></textarea>
                </div>
            </div>
        </div>

        <div style="display: grid; gap: 1.5rem; align-content: start;">
            <div class="card">
                <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1.5rem;">Page Details</h2>
                
                <div class="form-group">
                    <label class="form-label">Page Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Summer Collection" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">URL Slug (Optional)</label>
                    <input type="text" name="slug" class="form-control" placeholder="summer-collection">
                </div>

                <div class="form-group">
                    <label class="form-label">Hero Image URL</label>
                    <input type="url" name="hero_image" class="form-control" placeholder="https://...">
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="blocks" id="blocks-input">
</form>

<script>
    let blocks = [];
</script>
@include('admin.builder.script')
<script>
    renderBlocks();
</script>
@endsection
