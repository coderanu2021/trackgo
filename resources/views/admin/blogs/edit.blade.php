@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Edit Post</h1>
        <p style="color: var(--text-muted);">Modify your blog post details.</p>
    </div>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" style="max-width: 1000px;">
    @csrf
    @method('PUT')
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <div style="display: grid; gap: 1.5rem; align-content: start;">
            <div class="card">
                <div class="form-group">
                    <label class="form-label">Post Title</label>
                    <input type="text" name="title" value="{{ $blog->title }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Content</label>
                    <textarea name="content" id="editor" class="form-control">{{ $blog->content }}</textarea>
                </div>
            </div>

            <div class="card">
                <h3 style="margin-top: 0; margin-bottom: 1.5rem;"><i class="fas fa-search" style="color:var(--primary)"></i> SEO Optimization</h3>
                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ $blog->meta_title }}" class="form-control" placeholder="SEO Title">
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ $blog->meta_keywords }}" class="form-control" placeholder="keyword1, keyword2...">
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control" placeholder="Brief summary for search engines...">{{ $blog->meta_description }}</textarea>
                </div>
            </div>
        </div>

        <div style="display: grid; gap: 1.5rem; align-content: start;">
            <div class="card">
                <h3 style="margin-top: 0; font-size: 1rem; margin-bottom: 1rem;">Update</h3>
                <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ $blog->is_published ? 'checked' : '' }} style="width: 1.1rem; height: 1.1rem; cursor: pointer;">
                    <label for="is_published" style="font-weight: 500; cursor: pointer;">Is Published</label>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>

            <div class="card">
                <h3 style="margin-top: 0; font-size: 1rem; margin-bottom: 1rem;">Featured Image</h3>
                <div class="form-group">
                    <input type="text" name="image" value="{{ $blog->image }}" class="form-control">
                </div>
                @if($blog->image)
                    <div style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border);">
                        <img src="{{ $blog->image }}" style="width: 100%; height: auto; display: block;">
                    </div>
                @else
                    <div style="border: 2px dashed var(--border); border-radius: var(--radius-md); padding: 2rem; text-align: center; color: var(--text-muted);">
                        <i class="fas fa-image" style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.3;"></i>
                        <p style="font-size: 0.75rem;">No image set</p>
                    </div>
                @endif
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
