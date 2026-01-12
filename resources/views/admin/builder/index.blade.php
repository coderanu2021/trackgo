@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">Landing Pages</h1>
        <p style="color: var(--text-muted); font-size: 1rem;">Design and deploy high-conversion landing pages.</p>
    </div>
    <a href="{{ route('admin.builder.create') }}" class="btn btn-primary" style="padding: 0.875rem 2rem; border-radius: 14px;">
        <i class="fas fa-sparkles"></i> Create Experience
    </a>
</div>

<div class="table-container">
    <table id="builder-table">
        <thead>
            <tr>
                <th>Page Identity</th>
                <th>Public Link</th>
                <th>System Status</th>
                <th>Last Update</th>
                <th style="text-align: right;">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 42px; height: 42px; border-radius: 12px; background: var(--bg-main); display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-soft);">
                            <i class="fas fa-window-maximize" style="color: var(--accent); font-size: 1rem;"></i>
                        </div>
                        <div style="font-weight: 700; color: var(--text-main);">{{ $project->title }}</div>
                    </div>
                </td>
                <td style="color: var(--text-muted); font-family: monospace; font-size: 0.85rem;">/projects/{{ $project->slug }}</td>
                <td>
                    <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="badge" style="background: rgba(99, 102, 241, 0.1); color: var(--primary); text-decoration: none; border: 1px solid rgba(99, 102, 241, 0.2);">
                        PREVIEW <i class="fas fa-arrow-up-right-from-square" style="font-size: 0.65rem; margin-left: 0.4rem;"></i>
                    </a>
                </td>
                <td style="color: var(--text-light); font-weight: 500;">{{ $project->updated_at->diffForHumans() }}</td>
                <td style="text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <a href="{{ route('admin.builder.edit', $project->id) }}" class="btn" style="background: var(--bg-main); color: var(--accent); width: 40px; height: 40px; justify-content: center; padding: 0; border-radius: 10px;">
                            <i class="fas fa-layer-group"></i>
                        </a>
                        <form action="{{ route('admin.builder.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Delete this landing page?')" style="display: inline-block;">
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
    $('#builder-table').DataTable({
        "pageLength": 10,
        "ordering": true,
        "info": true,
        "order": [[3, "desc"]],
        "language": {
            "search": "",
            "searchPlaceholder": "Search repository...",
            "paginate": {
                "previous": "<i class='fas fa-chevron-left'></i>",
                "next": "<i class='fas fa-chevron-right'></i>"
            }
        }
    });
});
</script>
@endsection
