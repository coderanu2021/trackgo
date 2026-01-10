@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">Client Directory</h1>
        <p style="color: var(--text-muted); font-size: 1rem;">Manage your user base and access permissions.</p>
    </div>
</div>

<div class="table-container">
    <table id="users-table">
        <thead>
            <tr>
                <th>Identity</th>
                <th>Authentication Email</th>
                <th>Registration Date</th>
                <th style="text-align: right;">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 42px; height: 42px; border-radius: 12px; border: 2px solid var(--border-soft); display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--primary); background: var(--bg-main);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div style="font-weight: 700; color: var(--text-main);">{{ $user->name }}</div>
                    </div>
                </td>
                <td style="color: var(--text-muted); font-family: monospace; font-size: 0.9rem;">{{ $user->email }}</td>
                <td style="color: var(--text-light); font-weight: 500;">{{ $user->created_at->format('M d, Y') }} at {{ $user->created_at->format('H:i') }}</td>
                <td style="text-align: right;">
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Archive this user record?')" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.05); color: #ef4444; width: 40px; height: 40px; justify-content: center; padding: 0; border-radius: 10px;">
                            <i class="fas fa-trash-can"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#users-table').DataTable({
        "pageLength": 10,
        "ordering": true,
        "info": true,
        "language": {
            "search": "",
            "searchPlaceholder": "Search directory...",
            "paginate": {
                "previous": "<i class='fas fa-chevron-left'></i>",
                "next": "<i class='fas fa-chevron-right'></i>"
            }
        },
        "drawCallback": function() {
            $('.dataTables_paginate').addClass('premium-pagination');
        }
    });
});
</script>
@endsection
