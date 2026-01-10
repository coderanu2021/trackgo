@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div>
        <h1>Edit Plan: {{ $plan->name }}</h1>
        <p>Update plan pricing and features.</p>
    </div>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
        @csrf @method('PUT')
        
        <div class="form-group">
            <label>Plan Name</label>
            <input type="text" name="name" class="form-control" value="{{ $plan->name }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ $plan->price }}" required>
            </div>
            <div class="form-group">
                <label>Cycle</label>
                <select name="cycle" class="form-control">
                    <option value="monthly" {{ $plan->cycle == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ $plan->cycle == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    <option value="lifetime" {{ $plan->cycle == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Features (One per line)</label>
            <textarea name="features" class="form-control" rows="6">{{ $plan->features_text }}</textarea>
        </div>

        <div class="flex gap-4 mt-2">
            <div class="form-check">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ $plan->is_featured ? 'checked' : '' }}>
                <label for="is_featured">Featured Plan</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $plan->is_active ? 'checked' : '' }}>
                <label for="is_active">Active</label>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Update Plan</button>
            <a href="{{ route('admin.plans.index') }}" class="btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
