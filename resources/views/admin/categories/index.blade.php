@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">Category Taxonomy</h1>
        <p style="color: var(--text-muted); font-size: 1rem;">Organize your project and blog hierarchies.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" style="padding: 0.875rem 2rem; border-radius: 14px;">
        <i class="fas fa-plus"></i> New Category
    </a>
</div>

<div class="table-container">
    <table id="categories-table">
        <thead>
            <tr>
                <th>Category Name</th>
                <th>URL Segment (Slug)</th>
                <th>Status</th>
                <th style="text-align: right;">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 42px; height: 42px; border-radius: 12px; background: var(--bg-main); display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-soft);">
                            <i class="{{ $category->icon ?? 'fas fa-folder-tree' }}" style="color: var(--primary); font-size: 1rem;"></i>
                        </div>
                        <div style="font-weight: 700; color: var(--text-main);">{{ $category->name }}</div>
                    </div>
                </td>
                <td style="color: var(--text-muted); font-family: monospace; font-size: 0.9rem;">/category/{{ $category->slug }}</td>
                <td>
                    <span class="badge" style="background: {{ $category->is_active ? 'rgba(16,185,129,0.1)' : 'rgba(239, 68, 68, 0.1)' }};
                                          color: {{ $category->is_active ? '#065f46' : '#991b1b' }};">
                        {{ $category->is_active ? 'ACTIVE' : 'DISABLED' }}
                    </span>
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <button type="button" class="btn edit-category-btn" 
                                data-id="{{ $category->id }}"
                                data-name="{{ $category->name }}"
                                data-image="{{ $category->image }}"
                                data-icon="{{ $category->icon }}"
                                data-active="{{ $category->is_active }}"
                                style="background: var(--bg-main); color: var(--primary); width: 40px; height: 40px; justify-content: center; padding: 0; border-radius: 10px;">
                            <i class="fas fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Remove this category?')" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.05); color: #ef4444; width: 40px; height: 40px; justify-content: center; padding: 0; border-radius: 10px;">
                                <i class="fas fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: var(--shadow-base);">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-soft); padding: 1.5rem 2rem;">
                <h5 class="modal-title" style="font-weight: 800; color: var(--text-main);">Modify Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding: 2rem;">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Image URL</label>
                            <input type="text" name="image" id="edit_image" class="form-control" placeholder="https://...">
                        </div>
                        <div class="form-group">
                            <label>Icon Class</label>
                            <input type="text" name="icon" id="edit_icon" class="form-control" placeholder="fas fa-tag">
                        </div>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                        <label for="edit_is_active">Category is Active</label>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-soft); padding: 1.5rem 2rem; gap: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 12px; padding: 0.75rem 1.5rem;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 12px; padding: 0.75rem 2rem;">
                        <i class="fas fa-save"></i> Update Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#categories-table').DataTable({
        "pageLength": 10,
        "ordering": true,
        "info": true,
        "language": {
            "search": "",
            "searchPlaceholder": "Search taxonomy...",
            "paginate": {
                "previous": "<i class='fas fa-chevron-left'></i>",
                "next": "<i class='fas fa-chevron-right'></i>"
            }
        }
    });

    $(document).on('click', '.edit-category-btn', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const image = $(this).data('image');
        const icon = $(this).data('icon');
        const active = $(this).data('active');

        $('#editCategoryForm').attr('action', `{{ url('admin/categories') }}/${id}`);
        $('#edit_name').val(name);
        $('#edit_image').val(image);
        $('#edit_icon').val(icon);
        $('#edit_is_active').prop('checked', active == 1);

        const editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        editModal.show();
    });
});
</script>
@endsection
