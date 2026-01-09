@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 1.875rem; font-weight: 700; color: #111827;">Edit Page: {{ $page->title }}</h1>
    <div>
        <a href="{{ route('projects.show', $page->slug) }}" target="_blank" class="btn-primary" style="width: auto; padding: 0.75rem 2rem; background: #fff; color: var(--primary-color); border: 1px solid var(--primary-color); margin-right: 0.5rem; display: inline-block; text-decoration: none;">View Live</a>
        <button form="page-form" type="submit" class="btn-primary" style="width: auto; padding: 0.75rem 2rem;">Update Page</button>
    </div>
</div>

<form id="page-form" action="{{ route('admin.builder.update', $page->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="glass" style="padding: 2rem; border-radius: var(--radius-lg); margin-bottom: 2rem;">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Page Details</h2>
        
        <div class="form-group">
            <label class="form-label">Page Title</label>
            <input type="text" name="title" class="form-input" value="{{ $page->title }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">URL Slug</label>
            <input type="text" name="slug" class="form-input" value="{{ $page->slug }}">
        </div>

        <div class="form-group">
            <label class="form-label">Hero Image URL</label>
            <input type="url" name="hero_image" class="form-input" value="{{ $page->hero_image }}">
        </div>
    </div>

    <!-- Block Editor -->
    <div class="glass" style="padding: 2rem; border-radius: var(--radius-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600;">Content Blocks</h2>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <button type="button" onclick="addBlock('text')" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; background: white; border-radius: var(--radius-md); cursor: pointer;">+ Text</button>
                <button type="button" onclick="addBlock('image')" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; background: white; border-radius: var(--radius-md); cursor: pointer;">+ Image</button>
                <button type="button" onclick="addBlock('button')" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; background: white; border-radius: var(--radius-md); cursor: pointer;">+ Button</button>
                <button type="button" onclick="addBlock('table')" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; background: white; border-radius: var(--radius-md); cursor: pointer;">+ Table</button>
                <button type="button" onclick="addBlock('tabs')" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; background: white; border-radius: var(--radius-md); cursor: pointer;">+ Tabs</button>
                <button type="button" onclick="addBlock('features')" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; background: white; border-radius: var(--radius-md); cursor: pointer;">+ Features</button>
            </div>
        </div>

        <div id="blocks-container" style="display: flex; flex-direction: column; gap: 1rem;">
            <p id="empty-state" style="text-align: center; color: var(--text-light); padding: 2rem; border: 2px dashed #e5e7eb; border-radius: var(--radius-md); display: none;">
                No content blocks added yet. Start building your page!
            </p>
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
