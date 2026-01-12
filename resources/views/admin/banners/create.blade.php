@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Add New Banner</h1>
        <p style="color: var(--text-muted);">Create a new promotional banner for the home page.</p>
    </div>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label>Banner Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
            <small style="color: var(--text-light);">Recommended: 1200x400 for main, 400x400 for side.</small>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Title (Optional)</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. Summer Sale">
            </div>
            <div class="form-group">
                <label>Subtitle (Optional)</label>
                <input type="text" name="subtitle" class="form-control" placeholder="e.g. Up to 50% Off">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Link URL</label>
                <input type="url" name="link" class="form-control" placeholder="https://...">
            </div>
            <div class="form-group">
                <label>Placement Type</label>
                <select name="type" class="form-control" required>
                    <option value="side">Side Banner (Right of Slider)</option>
                    <option value="main">Main Slider Background</option>
                    <option value="footer">Footer / CTA Area</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Display Order</label>
                <input type="number" name="order" class="form-control" value="0">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1">Active / Visible</option>
                    <option value="0">Inactive / Hidden</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                <i class="fas fa-save"></i> Save Banner
            </button>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
