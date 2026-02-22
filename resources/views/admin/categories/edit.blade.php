@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Edit Category</h1>
        <p style="color: var(--text-muted);">Updating <span style="color: var(--primary); font-weight: 600;">{{ $category->name }}</span></p>
    </div>
</div>

<form id="category-form" action="{{ route('admin.categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="card" style="max-width: 800px;">
        <div class="form-section-title">
            <i class="fas fa-folder"></i>
            Category Information
        </div>

        <div class="form-group">
            <label class="required">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
            <span class="form-help">The display name for this category</span>
        </div>

        <div class="form-group">
            <label>Parent Category</label>
            <select name="parent_id" class="form-control" id="parent-category">
                <option value="">None (Root Category)</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <span class="form-help">Select a parent to create a subcategory</span>
        </div>

        <div class="form-group">
            <label>Category Icon (Optional)</label>
            <input type="text" name="image" class="form-control" value="{{ $category->image }}" placeholder="https://...">
            <span class="image-size-hint">400x400px, 1:1 ratio, max 512KB</span>
            <span class="form-help">Small icon image for category display</span>
        </div>

        <div class="form-group" id="banner-field" style="display: none;">
            <label>Category Banner (Root Categories Only)</label>
            <input type="text" name="banner" class="form-control" value="{{ $category->banner }}" placeholder="https://...">
            <span class="image-size-hint">1920x400px, 16:3.5 ratio, max 2MB</span>
            <span class="form-help">Large banner image shown on category page</span>
        </div>

        <div class="form-group">
            <label>Icon Class (Optional)</label>
            <input type="text" name="icon" class="form-control" value="{{ $category->icon }}" placeholder="fas fa-tag">
            <span class="form-help">FontAwesome icon class for display</span>
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $category->is_active ? 'checked' : '' }}>
                <label for="is_active">Active (visible on frontend)</label>
            </div>
        </div>
    </div>
</form>

@include('admin.components.form-actions', [
    'formId' => 'category-form',
    'submitText' => 'Save Changes',
    'cancelRoute' => route('admin.categories.index'),
    'showPreview' => false
])

<script>
    // Show/hide banner field based on parent category selection
    document.getElementById('parent-category').addEventListener('change', function() {
        const bannerField = document.getElementById('banner-field');
        if (this.value === '') {
            bannerField.style.display = 'block';
        } else {
            bannerField.style.display = 'none';
        }
    });
    
    // Trigger on page load
    document.getElementById('parent-category').dispatchEvent(new Event('change'));
</script>
@endsection
