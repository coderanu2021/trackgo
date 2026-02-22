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
                                <button onclick='showEditForm(@json($category->id), @json($category->name), @json($category->description), @json($category->order), @json($category->is_active))' class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i>
                                </button>
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

<!-- Edit Form Section (Hidden by default) -->
<div id="edit-section" style="display: none; margin-top: 2rem;">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="margin: 0;">Edit Category</h2>
            <button onclick="hideEditForm()" class="btn btn-sm btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </button>
        </div>
        
        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="required">Category Name</label>
                <input type="text" name="name" id="edit-name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="edit-description" rows="3" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Display Order</label>
                <input type="number" name="order" id="edit-order" class="form-control" min="0">
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="edit-is-active" value="1">
                    <label for="edit-is-active">Active (visible on frontend)</label>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <button type="button" onclick="hideEditForm()" class="btn btn-secondary">
                    Cancel
                </button>
            </div>
        </form>
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
    #edit-section {
        animation: slideDown 0.3s ease-out;
    }
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
function showEditForm(id, name, description, order, isActive) {
    // Set form action
    document.getElementById('edit-form').action = '{{ url("admin/gallery-categories") }}/' + id;
    
    // Fill form fields
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-description').value = description || '';
    document.getElementById('edit-order').value = order;
    document.getElementById('edit-is-active').checked = isActive;
    
    // Show edit section
    document.getElementById('edit-section').style.display = 'block';
    
    // Scroll to edit section
    document.getElementById('edit-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function hideEditForm() {
    document.getElementById('edit-section').style.display = 'none';
    document.getElementById('edit-form').reset();
}
</script>
@endsection
