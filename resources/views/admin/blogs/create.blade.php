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

<form action="{{ route('admin.blogs.store') }}" method="POST">
    @csrf
    <!-- Row 1: Title (Full Width) -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="form-group mb-0">
            <label class="form-label">Post Title</label>
            <input type="text" name="title" required class="form-control" placeholder="Enter a catchy title..." style="font-size: 1.25rem; font-weight: 600; padding: 1.25rem;">
        </div>
    </div>

    <!-- Row 2: Page Builder (Full Width) -->
    <div class="card" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-size: 1.1rem; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Blog Builder</h2>
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
            <p id="empty-state" style="text-align: center; color: var(--text-light); padding: 4rem 2rem; border: 2px dashed var(--border-soft); border-radius: var(--radius-lg); background: var(--bg-main);">
                <i class="fas fa-layer-group" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.2;"></i><br>
                <span style="font-size: 0.95rem; font-weight: 500;">No blocks added yet. Use the buttons above to start!</span>
            </p>
        </div>
        <input type="hidden" name="blocks" id="blocks-input">
    </div>

    <!-- Row 3: Meta & Settings (2 Columns) -->
    <div class="form-row" style="grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Left: SEO Card -->
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
            <div class="form-group mb-0">
                <label class="form-label">Meta Description</label>
                <textarea name="meta_description" rows="3" class="form-control" placeholder="Brief summary for search engines..."></textarea>
            </div>
        </div>

        <!-- Right: Publishing & Featured Image -->
        <div class="flex flex-col gap-4">
            <div class="card">
                <h3 style="margin-top: 0; font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Publishing</h3>
                <div class="form-row" style="grid-template-columns: 1fr; gap: 1rem;">
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="is_published" id="is_published" value="1" checked>
                            <label for="is_published">Publish immediately</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">
                    <i class="fas fa-paper-plane"></i> Save & Publish Post
                </button>
            </div>

            <div class="card">
                <h3 style="margin-top: 0; font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Featured Image</h3>
                <div class="form-group mb-0">
                    <div class="flex gap-2">
                        <input type="text" name="image" id="blog-image-input" class="form-control" placeholder="Image URL (e.g. https://...)">
                        <label class="btn btn-secondary" style="margin:0; cursor:pointer; padding:0 1rem; height:48px; display:flex; align-items:center; border-radius:12px;">
                            <i class="fas fa-upload"></i> <input type="file" onchange="uploadBlogImage(this)" accept="image/*" style="display:none;">
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



<script>
    // Initialize blocks array globally
    window.blocks = [];
    
    async function uploadBlogImage(input) {
        try {
            const file = input.files[0];
            if (!file) return;
            
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');
            
            const res = await fetch('{{ route('admin.pages.upload') }}', { 
                method: 'POST', 
                body: formData 
            });
            
            const data = await res.json();
            if (data.url) {
                document.getElementById('blog-image-input').value = data.url;
            } else {
                throw new Error('No URL returned');
            }
        } catch(e) { 
            console.error('Upload error:', e); 
            alert('Upload failed. Please try again.'); 
        }
    }
</script>

<script>
    window.enableBlockSettings = false;
</script>
@include('admin.pages.script')

<script>
    // Initialize the page after everything is loaded
    document.addEventListener('DOMContentLoaded', function() {
        try {
            if (typeof window.renderBlocks === 'function') {
                window.renderBlocks();
            } else {
                console.warn('renderBlocks function not available yet');
                // Retry after a short delay
                setTimeout(() => {
                    if (typeof window.renderBlocks === 'function') {
                        window.renderBlocks();
                    }
                }, 100);
            }
        } catch (error) {
            console.error('Blog create initialization error:', error);
        }
    });
</script>
@endsection
