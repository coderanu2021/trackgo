@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Order #{{ $order->id }}</h1>
        <p style="color: var(--text-muted);">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    <!-- Order Items & Customer -->
    <div style="display: grid; gap: 1.5rem; align-content: start;">
        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem;">Customer Information</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <label style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Customer Name</label>
                    <div style="font-weight: 600; font-size: 1rem;">{{ $order->customer_name }}</div>
                </div>
                <div>
                    <label style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Email Address</label>
                    <div style="font-weight: 600; font-size: 1rem;">{{ $order->customer_email }}</div>
                </div>
                <div>
                    <label style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Phone Number</label>
                    <div style="font-weight: 600; font-size: 1rem;">{{ $order->customer_phone }}</div>
                </div>
                <div>
                    <label style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Status</label>
                    <div>
                        <span class="badge @if($order->status == 'completed') badge-success @elseif($order->status == 'pending') badge-pending @elseif($order->status == 'cancelled') badge-danger @else badge-info @endif">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>
            </div>
            <div style="margin-top: 1.5rem;">
                <label style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Shipping Address</label>
                <div style="background: var(--bg-main); padding: 1rem; border-radius: var(--radius-md); margin-top: 0.5rem;">
                    {{ $order->shipping_address }}
                </div>
            </div>
        </div>

        <div class="card" style="padding: 0;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border);">
                <h3 style="margin: 0;">Order Items</h3>
            </div>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-main);">
                        <th style="padding: 1rem; text-align: left;">Product</th>
                        <th style="padding: 1rem; text-align: left;">Price</th>
                        <th style="padding: 1rem; text-align: left;">Quantity</th>
                        <th style="padding: 1rem; text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td style="padding: 1rem; font-weight: 600;">{{ $item->product->title ?? 'Deleted Product' }}</td>
                        <td style="padding: 1rem;">₹{{ number_format($item->price, 2) }}</td>
                        <td style="padding: 1rem;">{{ $item->quantity }}</td>
                        <td style="padding: 1rem; text-align: right; font-weight: 600;">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding: 1.5rem; display: flex; justify-content: flex-end; background: #fbfcfd;">
                <div style="width: 200px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="color: var(--text-muted);">Subtotal</span>
                        <span>₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 1.25rem; color: var(--text-main);">
                        <span>Total</span>
                        <span>₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div style="display: grid; gap: 1.5rem; align-content: start;">
        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem;">Update Status</h3>
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Order Status</label>
                    <select name="status" class="form-control">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-save"></i> Update Order
                </button>
            </form>
        </div>

        <div class="card" style="text-align: center;">
            <i class="fas fa-print" style="font-size: 2rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <h3 style="margin: 0 0 0.5rem 0;">Invoice</h3>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">Generate a PDF invoice for this order.</p>
            <button class="btn btn-secondary" style="width: 100%;" onclick="window.print()">
                <i class="fas fa-download"></i> Download PDF
            </button>
        </div>
    </div>
</div>
@endsection
