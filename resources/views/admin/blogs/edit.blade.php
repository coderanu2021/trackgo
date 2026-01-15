@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Edit Post</h1>
        <p style="color: var(--text-muted);">Modify your blog post details.</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" class="btn btn-secondary" style="border-radius: 20px; font-size: 0.8rem;">
            <i class="fas fa-eye"></i> Preview
        </a>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST">
    @csrf
    @method('PUT')
    <!-- Row 1: Title (Full Width) -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="form-group mb-0">
            <label class="form-label">Post Title</label>
            <input type="text" name="title" value="{{ $blog->title }}" required class="form-control" style="font-size: 1.25rem; font-weight: 600; padding: 1.25rem;">
        </div>
    </div>

    <!-- Row 2: Page Builder (Full Width) -->
    <div class="card" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-size: 1.1rem; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Blog Content Builder</h2>
                <p style="font-size: 0.75rem; color: var(--text-light); margin: 0.25rem 0 0;">Add and arrange blocks to build your post.</p>
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
            <!-- Blocks will be rendered here by JavaScript -->
        </div>
        <input type="hidden" name="blocks" id="blocks-input" value="{{ json_encode($blog->content) }}">
    </div>

    <!-- Row 3: Meta & Settings (2 Columns) -->
    <div class="form-row" style="grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Left: SEO Card -->
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
            <div class="form-group mb-0">
                <label class="form-label">Meta Description</label>
                <textarea name="meta_description" rows="3" class="form-control" placeholder="Brief summary for search engines...">{{ $blog->meta_description }}</textarea>
            </div>
        </div>

        <!-- Right: Publishing & Featured Image -->
        <div class="flex flex-col gap-4">
            <div class="card">
                <h3 style="margin-top: 0; font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Update Settings</h3>
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="is_published" id="is_published" value="1" {{ $blog->is_published ? 'checked' : '' }}>
                        <label for="is_published">Is Published</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>

            <div class="card">
                <h3 style="margin-top: 0; font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Featured Image</h3>
                <div class="form-group">
                    <div class="flex gap-2">
                        <input type="text" name="image" id="blog-image-input" value="{{ $blog->image }}" class="form-control" placeholder="Image URL (e.g. https://...)">
                        <label class="btn btn-secondary" style="margin:0; cursor:pointer; padding:0 1rem; height:48px; display:flex; align-items:center; border-radius:12px;">
                            <i class="fas fa-upload"></i> <input type="file" onchange="uploadBlogImage(this)" accept="image/*" style="display:none;">
                        </label>
                    </div>
                </div>
                @if($blog->image)
                    <div id="image-preview" style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-soft); box-shadow: var(--shadow-soft);">
                        <img src="{{ $blog->image }}" style="width: 100%; height: auto; display: block;">
                    </div>
                @endif
            </div>
        </div>
    </div>
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
    let blocks = {!! json_encode($blog->content) !!} || [];
    async function uploadBlogImage(input) {
        const file = input.files[0];
        if (!file) return;
        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');
        try {
            const res = await fetch('{{ route('admin.builder.upload') }}', { method: 'POST', body: formData });
            const data = await res.json();
            if (data.url) {
                document.getElementById('blog-image-input').value = data.url;
                // Update preview if exists
                let preview = document.getElementById('image-preview');
                if(!preview) {
                   // Create it?
                } else {
                    preview.querySelector('img').src = data.url;
                }
            }
        } catch(e) { console.error(e); alert('Upload failed'); }
    }
</script>
@include('admin.builder.script')
<script>
    renderBlocks();
</script>
@endsection
