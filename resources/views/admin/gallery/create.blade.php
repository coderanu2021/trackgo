@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Add Gallery Image</h1>
        <p style="color: var(--text-muted);">Upload a new image to your gallery.</p>
    </div>
</div>

<form id="gallery-form" action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="form-section-title">
            <i class="fas fa-image"></i>
            Image Details
        </div>

        <div class="form-group">
            <label class="required">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" 
                   placeholder="Enter image title" required>
            <span class="form-help">A descriptive title for this gallery image</span>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3" class="form-control" 
                      placeholder="Optional description for this image">{{ old('description') }}</textarea>
            <span class="form-help">Brief description shown in lightbox view</span>
        </div>

        <div class="form-group">
            <label class="required">Image</label>
            <span class="image-size-hint">1200x900px, 4:3 ratio, max 2MB</span>
            <input type="file" name="image" class="form-control" accept="image/*" required>
            <span class="form-help">Upload a high-quality image for your gallery</span>
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control">
                <option value="">Uncategorized</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <span class="form-help">Assign this image to a category for filtering</span>
        </div>

        <div class="form-group">
            <label>Display Order</label>
            <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" 
                   placeholder="0" min="0">
            <span class="form-help">Lower numbers appear first (0 = highest priority)</span>
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="is_active" id="is_active" value="1" 
                       {{ old('is_active', true) ? 'checked' : '' }}>
                <label for="is_active">Active (visible on frontend)</label>
            </div>
        </div>
    </div>
</form>

@include('admin.components.form-actions', [
    'formId' => 'gallery-form',
    'submitText' => 'Add to Gallery',
    'cancelRoute' => route('admin.gallery.index'),
    'showPreview' => false
])
@endsection
