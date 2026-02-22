@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Gallery Categories</h1>
        <p style="color: var(--text-muted);">Organize your gallery images into categories.</p>
    </div>
    <a href="{{ route('admin.gallery-categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Category
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Images Count</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td>{{ $category->galleries_count }} images</td>
                        <td>{{ $category->order }}</td>
                        <td>
                            <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-secondary' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.gallery-categories.edit', $category->id) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.gallery-categories.destroy', $category->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure? This will unassign all images from this category.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 3rem; color: var(--text-light);">
                            <i class="fas fa-folder-open" style="font-size: 3rem; opacity: 0.2; margin-bottom: 1rem;"></i>
                            <p>No gallery categories yet. Create your first category!</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }
    .badge-secondary {
        background: #f3f4f6;
        color: #6b7280;
    }
    .btn-danger {
        background: #ef4444;
        color: white;
        border: none;
    }
    .btn-danger:hover {
        background: #dc2626;
    }
    code {
        background: #f3f4f6;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.85rem;
    }
</style>
@endsection
