@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Create General Page</h1>
        <p style="color: var(--text-muted);">Build a standard content page using the section builder.</p>
    </div>
    <button form="page-form" type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem;">
        <i class="fas fa-check"></i> Save Page
    </button>
</div>

<form id="page-form" action="{{ route('admin.pages.store') }}" method="POST">
    @csrf
    

    <!-- Row 1: Content Designer (Full Width) -->
    <div class="card" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-size: 1.1rem; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Content Designer</h2>
                <p style="font-size: 0.75rem; color: var(--text-light); margin: 0.25rem 0 0;">Select and arrange sections to design your page.</p>
            </div>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <button type="button" onclick="addBlock('text')" class="btn btn-secondary" title="Add Text Area">
                    <i class="fas fa-font"></i> Text
                </button>
                <button type="button" onclick="addBlock('image')" class="btn btn-secondary" title="Add Image">
                    <i class="fas fa-image"></i> Image
                </button>
                <button type="button" onclick="addBlock('button')" class="btn btn-secondary" title="Add Button">
                    <i class="fas fa-link"></i> Button
                </button>
                <button type="button" onclick="addBlock('features')" class="btn btn-secondary" title="Add Feature List">
                    <i class="fas fa-list-check"></i> Features
                </button>
                <button type="button" onclick="addBlock('tabs')" class="btn btn-secondary" title="Add Tabs">
                    <i class="fas fa-folder-tree"></i> Tabs
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

        <!-- Page Settings Card -->
        <div class="card">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Page Settings</h2>
            
            <div class="form-group">
                <label>Page Heading</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. About Our Company" required>
            </div>
            
            <div class="form-group">
                <label>Custom URL Slug</label>
                <input type="text" name="slug" class="form-control" placeholder="e.g. about-us">
                <small style="color: var(--text-light);">Leave blank to generate from heading.</small>
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
