@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Home Banners</h1>
        <p style="color: var(--text-muted);">Manage your home page banners and promotions.</p>
    </div>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Banner
    </a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Details</th>
                <th>Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($banners as $banner)
            <tr>
                <td>
                    <img src="{{ $banner->image }}" alt="Banner" style="width: 120px; height: 60px; object-fit: cover; border-radius: 8px;">
                </td>
                <td>
                    <div style="font-weight: 700;">{{ $banner->title ?? 'No Title' }}</div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $banner->subtitle ?? 'No Subtitle' }}</div>
                </td>
                <td>
                    <span class="badge" style="background: var(--primary-soft); color: var(--primary);">{{ ucfirst($banner->type) }}</span>
                </td>
                <td>
                    <span class="badge" style="background: {{ $banner->is_active ? 'rgba(34, 197, 94, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $banner->is_active ? '#22c55e' : '#ef4444' }};">
                        {{ $banner->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; color: #ef4444;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
