@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Create Category</h1>
        <p style="color: var(--text-muted);">Organize your products into meaningful groups.</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card" style="max-width: 700px;">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Smartphones">
        </div>

        <div class="form-group" style="margin-bottom: 1rem;">
            <label class="form-label">Parent Category</label>
            <select name="parent_id" class="form-control">
                <option value="">None (Main Category)</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label">Image URL (Optional)</label>
                <input type="text" name="image" class="form-control" placeholder="https://...">
            </div>
            <div class="form-group">
                <label class="form-label">Icon Class (Optional)</label>
                <div style="position: relative;">
                    <input type="text" name="icon" class="form-control" placeholder="fas fa-tag">
                    <i class="fas fa-info-circle" style="position: absolute; right: 1rem; top: 0.75rem; color: var(--text-light);" title="Use FontAwesome classes"></i>
                </div>
            </div>
        </div>

        <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem; margin-top: 1rem;">
            <input type="checkbox" name="is_active" id="is_active" value="1" checked style="width: 1.1rem; height: 1.1rem; cursor: pointer;">
            <label for="is_active" style="font-weight: 500; cursor: pointer;">Enable this category</label>
        </div>

        <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem;">
                <i class="fas fa-check"></i> Create Category
            </button>
        </div>
    </form>
</div>
@endsection
