@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">Blog Builder</h1>
        <p style="color: var(--text-muted); font-size: 1rem;">Craft and manage your publication content.</p>
    </div>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary" style="padding: 0.875rem 2rem; border-radius: 14px;">
        <i class="fas fa-plus"></i> New Article
    </a>
</div>

<div class="table-container">
    <table id="blogs-table">
        <thead>
            <tr>
                <th>Article Identity</th>
                <th>Author</th>
                <th>Publish State</th>
                <th>Creation Date</th>
                <th style="text-align: right;">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
            <tr>
                <td style="max-width: 400px;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; border-radius: 10px; background: var(--bg-main); flex-shrink: 0; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-soft);">
                            <i class="fas fa-newspaper" style="color: var(--primary); font-size: 1.1rem;"></i>
                        </div>
                        <div style="font-weight: 700; color: var(--text-main); font-size: 0.95rem; line-height: 1.3;">{{ $blog->title }}</div>
                    </div>
                </td>
                <td style="color: var(--text-muted); font-weight: 600;">{{ $blog->user->name ?? 'System Admin' }}</td>
                <td>
                    <span class="badge" style="background: {{ $blog->is_published ? 'rgba(16,185,129,0.1)' : 'rgba(100, 116, 139, 0.1)' }};
                                          color: {{ $blog->is_published ? '#065f46' : '#475569' }};">
                        {{ $blog->is_published ? 'PUBLISHED' : 'DRAFT' }}
                    </span>
                </td>
                <td style="color: var(--text-light); font-weight: 500;">{{ $blog->created_at->format('M d, Y') }}</td>
                <td style="text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn" style="background: var(--bg-main); color: var(--primary); width: 40px; height: 40px; justify-content: center; padding: 0; border-radius: 10px;">
                            <i class="fas fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Erase this article?')" style="display: inline-block;">
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
    $('#blogs-table').DataTable({
        "pageLength": 10,
        "ordering": true,
        "info": true,
        "order": [[3, "desc"]],
        "language": {
            "search": "",
            "searchPlaceholder": "Search articles...",
            "paginate": {
                "previous": "<i class='fas fa-chevron-left'></i>",
                "next": "<i class='fas fa-chevron-right'></i>"
            }
        }
    });
});
</script>
@endsection
