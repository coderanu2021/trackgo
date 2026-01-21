@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.5rem;">Brands</h2>
        <p style="color: var(--text-muted);">Manage your partner and top brands.</p>
    </div>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Brand
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 15%;">Logo</th>
                    <th style="width: 25%;">Name</th>
                    <th style="width: 25%;">URL</th>
                    <th style="width: 15%;">Status</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                    <tr>
                        <td>{{ $brand->id }}</td>
                        <td>
                            <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}" style="height: 40px; width: auto; object-fit: contain; border-radius: 4px;">
                        </td>
                        <td style="font-weight: 600;">{{ $brand->name }}</td>
                        <td>
                            @if($brand->url)
                                <a href="{{ $brand->url }}" target="_blank" style="color: var(--primary);"><i class="fas fa-external-link-alt"></i> Link</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($brand->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-star fa-3x mb-3 opacity-25"></i>
                                <p>No brands found.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
