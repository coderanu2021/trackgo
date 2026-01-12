@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Edit Banner</h1>
        <p style="color: var(--text-muted);">Update promotional banner details.</p>
    </div>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Current Image</label>
            <div style="margin-bottom: 1rem;">
                <img src="{{ $banner->image }}" alt="Current" style="width: 200px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-soft);">
            </div>
            <label>Change Image (Optional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Title (Optional)</label>
                <input type="text" name="title" class="form-control" value="{{ $banner->title }}" placeholder="e.g. Summer Sale">
            </div>
            <div class="form-group">
                <label>Subtitle (Optional)</label>
                <input type="text" name="subtitle" class="form-control" value="{{ $banner->subtitle }}" placeholder="e.g. Up to 50% Off">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Link URL</label>
                <input type="url" name="link" class="form-control" value="{{ $banner->link }}" placeholder="https://...">
            </div>
            <div class="form-group">
                <label>Placement Type</label>
                <select name="type" class="form-control" required>
                    <option value="side" {{ $banner->type == 'side' ? 'selected' : '' }}>Side Banner (Right of Slider)</option>
                    <option value="main" {{ $banner->type == 'main' ? 'selected' : '' }}>Main Slider Background</option>
                    <option value="footer" {{ $banner->type == 'footer' ? 'selected' : '' }}>Footer / CTA Area</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Display Order</label>
                <input type="number" name="order" class="form-control" value="{{ $banner->order }}">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1" {{ $banner->is_active ? 'selected' : '' }}>Active / Visible</option>
                    <option value="0" {{ !$banner->is_active ? 'selected' : '' }}>Inactive / Hidden</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                <i class="fas fa-save"></i> Update Banner
            </button>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
