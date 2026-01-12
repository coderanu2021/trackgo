@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">Page Builder</h1>
        <p style="color: var(--text-muted); font-size: 1rem;">Create and manage standard content pages for your website.</p>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary" style="padding: 0.875rem 2rem; border-radius: 14px;">
        <i class="fas fa-plus"></i> Create New Page
    </a>
</div>

<div class="table-container">
    <table id="pages-table">
        <thead>
            <tr>
                <th>Page Title</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Last Update</th>
                <th style="text-align: right;">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 42px; height: 42px; border-radius: 12px; background: var(--bg-main); display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-soft);">
                            <i class="fas fa-file-lines" style="color: var(--primary); font-size: 1rem;"></i>
                        </div>
                        <div style="font-weight: 700; color: var(--text-main);">{{ $page->title }}</div>
                    </div>
                </td>
                <td style="color: var(--text-muted); font-family: monospace; font-size: 0.85rem;">/{{ $page->slug }}</td>
                <td>
                    <span class="badge {{ $page->is_active ? 'badge-success' : 'badge-danger' }}" 
                          style="background: {{ $page->is_active ? 'rgba(16,185,129,0.1)' : 'rgba(239, 68, 68, 0.1)' }};
                                 color: {{ $page->is_active ? '#065f46' : '#991b1b' }};">
                        {{ $page->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td style="color: var(--text-light); font-weight: 500;">{{ $page->updated_at->diffForHumans() }}</td>
                <td style="text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn" style="background: var(--bg-main); color: var(--accent); width: 40px; height: 40px; justify-content: center; padding: 0; border-radius: 10px;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Delete this page?')" style="display: inline-block;">
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
    $('#pages-table').DataTable({
        "pageLength": 10,
        "ordering": true,
        "info": true,
        "order": [[3, "desc"]],
        "language": {
            "search": "",
            "searchPlaceholder": "Search pages...",
            "paginate": {
                "previous": "<i class='fas fa-chevron-left'></i>",
                "next": "<i class='fas fa-chevron-right'></i>"
            }
        }
    });
});
</script>
@endsection
