@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Create Post</h1>
        <p style="color: var(--text-muted);">Share your latest news and updates.</p>
    </div>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<form action="{{ route('admin.blogs.store') }}" method="POST" style="max-width: 1000px;">
    @csrf
    <div class="form-row" style="grid-template-columns: 2fr 1fr;">
        <div class="flex flex-col gap-4">
            <div class="card">
                <div class="form-group">
                    <label class="form-label">Post Title</label>
                    <input type="text" name="title" required class="form-control" placeholder="Enter a catchy title...">
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Content</label>
                    <textarea name="content" id="editor" class="form-control" placeholder="Write your post content here..."></textarea>
                </div>
            </div>

            <div class="card">
                <h3 style="margin-top: 0; margin-bottom: 1.5rem;"><i class="fas fa-search" style="color:var(--primary)"></i> SEO Optimization</h3>
                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" placeholder="SEO Title">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control" placeholder="keyword1, keyword2...">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control" placeholder="Brief summary for search engines..."></textarea>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <div class="card">
                <h3 style="margin-top: 0; font-size: 1rem; margin-bottom: 1rem;">Publishing</h3>
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="is_published" id="is_published" value="1" checked>
                        <label for="is_published">Publish immediately</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    <i class="fas fa-paper-plane"></i> Save & Publish
                </button>
            </div>

            <div class="card">
                <h3 style="margin-top: 0; font-size: 1rem; margin-bottom: 1rem;">Featured Image</h3>
                <div class="form-group">
                    <input type="text" name="image" class="form-control" placeholder="Image URL (e.g. https://...)">
                </div>
                <div style="border: 2px dashed var(--border-soft); border-radius: var(--radius-md); padding: 2rem; text-align: center; color: var(--text-muted); background: var(--bg-main);">
                    <i class="fas fa-image" style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.3;"></i>
                    <p style="font-size: 0.75rem;">Preview will appear here once URL is added</p>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection
