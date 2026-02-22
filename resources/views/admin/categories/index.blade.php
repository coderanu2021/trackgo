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
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn" 
                                style="background: var(--bg-main); color: var(--primary); width: 40px; height: 40px; justify-content: center; padding: 0; border-radius: 10px; display: flex; align-items: center;">
                            <i class="fas fa-pen-to-square"></i>
                        </a>
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
});
</script>
@endsection
