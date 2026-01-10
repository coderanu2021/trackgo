@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div>
        <h1>Newsletter Subscribers</h1>
        <p>Manage your audience and export email lists.</p>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Email Address</th>
                <th>Status</th>
                <th>Subscribed At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscribers as $sub)
            <tr>
                <td><strong>{{ $sub->email }}</strong></td>
                <td>
                    @if($sub->is_active)
                        <span class="status-badge status-active">Active Subscriber</span>
                    @else
                        <span class="status-badge status-inactive">Paused / Inactive</span>
                    @endif
                </td>
                <td>{{ $sub->created_at->format('M d, Y H:i') }}</td>
                <td>
                    <div class="flex gap-2">
                        <form action="{{ route('admin.newsletters.toggle', $sub->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm" style="background:#f1f5f9;" title="Toggle Status">
                                <i class="fas fa-{{ $sub->is_active ? 'pause' : 'play' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.newsletters.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this subscriber?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; padding: 3rem;">
                    <i class="fas fa-envelope-open" style="font-size: 3rem; color: var(--border); margin-bottom: 1rem; display:block;"></i>
                    <p>No subscribers found in your list.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
