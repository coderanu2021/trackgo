@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">Modify Category</h1>
        <p style="color: var(--text-muted); font-size: 1.05rem;">Updating parameters for <span style="color: var(--primary); font-weight: 700;">{{ $category->name }}</span></p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary" style="border-radius: 14px;">
        <i class="fas fa-arrow-left"></i> Back to Archive
    </a>
</div>

<div class="card" style="max-width: 700px;">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>

        <div class="form-group" style="margin-bottom: 1rem;">
            <label class="form-label">Parent Category</label>
            <select name="parent_id" class="form-control">
                <option value="">None (Main Category)</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label">Image URL (Optional)</label>
                <input type="text" name="image" class="form-control" value="{{ $category->image }}" placeholder="https://...">
            </div>
            <div class="form-group">
                <label class="form-label">Icon Class (Optional)</label>
                <div style="position: relative;">
                    <input type="text" name="icon" class="form-control" value="{{ $category->icon }}" placeholder="fas fa-tag">
                    <i class="fas fa-info-circle" style="position: absolute; right: 1rem; top: 0.75rem; color: var(--text-light);" title="Use FontAwesome classes"></i>
                </div>
            </div>
        </div>

        <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem; margin-top: 1rem;">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} style="width: 1.1rem; height: 1.1rem; cursor: pointer;">
            <label for="is_active" style="font-weight: 500; cursor: pointer;">Category is active</label>
        </div>

        <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem;">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
