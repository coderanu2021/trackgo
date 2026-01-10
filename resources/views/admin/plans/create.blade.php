@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div>
        <h1>Create New Plan</h1>
        <p>Define a new pricing tier for your platform.</p>
    </div>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.plans.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Plan Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Professional" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" name="price" class="form-control" placeholder="79.00" required>
            </div>
            <div class="form-group">
                <label>Cycle</label>
                <select name="cycle" class="form-control">
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                    <option value="lifetime">Lifetime</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Features (One per line)</label>
            <textarea name="features" class="form-control" rows="6" placeholder="Unlimited Products&#10;Priority Support&#10;API Access"></textarea>
        </div>

        <div style="display: flex; gap: 2rem; margin-top: 1rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="is_featured" value="1"> Featured Plan
            </label>
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" checked> Active
            </label>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Create Plan</button>
            <a href="{{ route('admin.plans.index') }}" class="btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
