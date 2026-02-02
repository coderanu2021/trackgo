@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div>
        <h1>Pricing Plans</h1>
        <p>Manage your subscription tiers and features.</p>
    </div>
    <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Plan
    </a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Cycle</th>
                <th>Featured</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plans as $plan)
            <tr>
                <td><strong>{{ $plan->name }}</strong></td>
                <td>{{ $plan->currency }} {{ formatIndianPrice($plan->price, 2) }}</td>
                <td><span class="badge" style="background:#e2e8f0; color:#475569;">{{ ucfirst($plan->cycle) }}</span></td>
                <td>
                    @if($plan->is_featured)
                        <span class="badge badge-success">Yes</span>
                    @else
                        <span class="badge" style="background:#eee;">No</span>
                    @endif
                </td>
                <td>
                    @if($plan->is_active)
                        <span class="status-badge status-active">Active</span>
                    @else
                        <span class="status-badge status-inactive">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.plans.edit', $plan->id) }}" class="btn btn-sm" style="background:#f1f5f9;"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
