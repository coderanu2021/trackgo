@extends('layouts.admin')

@section('content')
<div class="card">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Manager
        </a>
    </div>

    <h1>Edit Subscription #{{ $subscription->id }}</h1>

    <form action="{{ route('admin.subscriptions.update', $subscription->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        @if($subscription->user_id)
        <div class="form-group">
            <label>User (Customer)</label>
            <select name="user_id" class="form-control" disabled style="background-color: #f0f0f0;">
                <option value="{{ $subscription->user_id }}">{{ $subscription->user->name }} ({{ $subscription->user->email }})</option>
            </select>
            <small>User cannot be changed once linked.</small>
        </div>
        @else
        <div class="form-group">
            <label>User (Customer)</label>
            <input type="text" class="form-control" value="Manual Entry (Guest Customer)" disabled style="background-color: #f0f0f0;">
        </div>

        <div style="padding: 1rem; background: #f9f9f9; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 1.5rem;">
            <h4 style="font-size: 1rem; margin-bottom: 1rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600;">Manual Customer Details</h4>
            <div class="form-group">
                <label>Customer Name <span class="text-danger">*</span></label>
                <input type="text" name="customer_name" class="form-control" value="{{ $subscription->customer_name }}">
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Phone Number</label>
                    <input type="text" name="customer_phone" class="form-control" value="{{ $subscription->customer_phone }}">
                </div>
                <div class="col-md-6 form-group">
                    <label>Email Address</label>
                    <input type="email" name="customer_email" class="form-control" value="{{ $subscription->customer_email }}">
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-md-6 form-group">
                <label>Plan (Package)</label>
                <select name="plan_id" class="form-control">
                    <option value="">None / Custom</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ $subscription->plan_id == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Product (If applicable)</label>
                <select name="product_id" class="form-control">
                    <option value="">None</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ $subscription->product_id == $product->id ? 'selected' : '' }}>{{ $product->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $subscription->start_date->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-6 form-group">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ $subscription->end_date->format('Y-m-d') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active" {{ $subscription->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="expired" {{ $subscription->status == 'expired' ? 'selected' : '' }}>Expired</option>
                <option value="cancelled" {{ $subscription->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="form-group">
            <label>Linked Order ID</label>
            <input type="number" name="order_id" class="form-control" value="{{ $subscription->order_id }}">
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Update Subscription</button>
    </form>
</div>
@endsection
