@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Gallery Management</h1>
        <p style="color: var(--text-muted);">Manage your gallery images and categories.</p>
    </div>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Image
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
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleries as $gallery)
                    <tr>
                        <td>
                            <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->title }}" 
                                 style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td>{{ $gallery->title }}</td>
                        <td>{{ $gallery->category->name ?? 'Uncategorized' }}</td>
                        <td>{{ $gallery->order }}</td>
                        <td>
                            <span class="badge {{ $gallery->is_active ? 'badge-success' : 'badge-secondary' }}">
                                {{ $gallery->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this image?');">
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
                            <i class="fas fa-images" style="font-size: 3rem; opacity: 0.2; margin-bottom: 1rem;"></i>
                            <p>No gallery images yet. Add your first image!</p>
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
</style>
@endsection
