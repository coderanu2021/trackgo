@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div>
        <h1>FAQ Management</h1>
        <p>Manage frequently asked questions and their categories.</p>
    </div>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New FAQ
    </a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Order</th>
                <th>Category</th>
                <th>Question</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faqs as $faq)
            <tr>
                <td>{{ $faq->sort_order }}</td>
                <td><span class="badge" style="background:#f1f5f9; color:#475569;">{{ $faq->category }}</span></td>
                <td><strong>{{ $faq->question }}</strong></td>
                <td>
                    @if($faq->is_active)
                        <span class="status-badge status-active">Active</span>
                    @else
                        <span class="status-badge status-inactive">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-sm" style="background:#f1f5f9;"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
