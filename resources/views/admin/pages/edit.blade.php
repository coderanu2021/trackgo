@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Edit General Page</h1>
        <p style="color: var(--text-muted);">Refine your page content and structure.</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="btn btn-secondary" style="border-radius: 20px; font-size: 0.8rem;">
            <i class="fas fa-eye"></i> Preview
        </a>
        <button form="page-form" type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem;">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </div>
</div>

<form id="page-form" action="{{ route('admin.pages.update', $page->id) }}" method="POST">
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
            <div class="card">
                <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Page Settings</h2>
                
                <div class="form-group">
                    <label>Page Heading</label>
                    <input type="text" name="title" class="form-control" value="{{ $page->title }}" placeholder="e.g. About Our Company" required>
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

<script>
    let blocks = {!! json_encode($page->content) !!} || [];
</script>
@include('admin.builder.script')
<script>
    renderBlocks();
</script>
@endsection
