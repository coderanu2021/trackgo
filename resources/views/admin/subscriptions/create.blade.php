@extends('layouts.admin')

@section('content')
<div class="card">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Manager
        </a>
    </div>

    <h1>Add Subscription</h1>

    <form action="{{ route('admin.subscriptions.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>User (Customer)</label>
            <select name="user_id" id="user_select" class="form-control" onchange="toggleManualFields()">
                <option value="">-- Manual Entry --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            <small class="text-muted">Select "Manual Entry" to enter customer details manually.</small>
        </div>

        <div id="manual_fields" style="padding: 1rem; background: #f9f9f9; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 1.5rem;">
            <h4 style="font-size: 1rem; margin-bottom: 1rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600;">Manual Customer Details</h4>
            <div class="form-group">
                <label>Customer Name <span class="text-danger">*</span></label>
                <input type="text" name="customer_name" class="form-control" placeholder="e.g. John Doe">
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Phone Number</label>
                    <input type="text" name="customer_phone" class="form-control" placeholder="e.g. +123456789">
                </div>
                <div class="col-md-6 form-group">
                    <label>Email Address</label>
                    <input type="email" name="customer_email" class="form-control" placeholder="e.g. john@example.com">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label>Plan (Package)</label>
                <select name="plan_id" class="form-control">
                    <option value="">None / Custom</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Product (If applicable)</label>
                <select name="product_id" class="form-control">
                    <option value="">None</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="expired">Expired</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <div class="form-group">
            <label>Linked Order ID (Optional, for Invoice No)</label>
            <input type="number" name="order_id" class="form-control" placeholder="e.g. 104">
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Create Subscription</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function toggleManualFields() {
        var userSelect = document.getElementById('user_select');
        var manualFields = document.getElementById('manual_fields');
        
        if (userSelect.value === "") {
            manualFields.style.display = 'block';
        } else {
            manualFields.style.display = 'none';
        }
    }

    // Run on load
    document.addEventListener('DOMContentLoaded', function() {
        toggleManualFields();
    });
</script>
@endsection
