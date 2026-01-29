@extends('customer.layout')

@section('customer_content')
<div class="dashboard-header" style="margin-bottom: 3rem;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin: 0; font-family: 'Outfit';">Welcome Back, {{ Auth::user()->name }}!</h1>
    <p style="color: var(--text-muted); margin-top: 0.5rem; font-size: 1.1rem;">Manage your orders and account settings from your personal dashboard.</p>
</div>

<!-- Stats Row -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2rem; margin-bottom: 3.5rem;">
    <div class="stat-card" style="background: var(--white); padding: 2.5rem; border-radius: 24px; box-shadow: var(--shadow-md); border: 1px solid var(--border-soft); display: flex; align-items: center; gap: 2rem;">
        <div style="width: 64px; height: 64px; background: var(--primary-soft); color: var(--primary); border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem;">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div>
            <div style="font-size: 2.25rem; font-weight: 800; line-height: 1; font-family: 'Outfit';">{{ $total_orders }}</div>
            <div style="color: var(--text-muted); font-size: 0.95rem; font-weight: 600; margin-top: 0.35rem; text-transform: uppercase; letter-spacing: 0.05em;">Total Orders</div>
        </div>
    </div>

    <div class="stat-card" style="background: var(--white); padding: 2.5rem; border-radius: 24px; box-shadow: var(--shadow-md); border: 1px solid var(--border-soft); display: flex; align-items: center; gap: 2rem;">
        <div style="width: 64px; height: 64px; background: rgba(34, 197, 94, 0.1); color: #22c55e; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <div style="font-size: 2.25rem; font-weight: 800; line-height: 1; font-family: 'Outfit';">{{ $recent_orders->where('status', 'completed')->count() }}</div>
            <div style="color: var(--text-muted); font-size: 0.95rem; font-weight: 600; margin-top: 0.35rem; text-transform: uppercase; letter-spacing: 0.05em;">Completed</div>
        </div>
    </div>
</div>

<!-- Recent Orders Section -->
<div class="card" style="background: var(--white); border-radius: 24px; box-shadow: var(--shadow-md); border: 1px solid var(--border-soft); overflow: hidden;">
    <div style="padding: 2rem 2.5rem; border-bottom: 1px solid var(--border-soft); display: flex; justify-content: space-between; align-items: center;">
        <h2 style="font-family: 'Outfit'; font-size: 1.5rem; margin: 0;">Recent Orders</h2>
        <a href="{{ route('customer.orders') }}" style="color: var(--primary); font-weight: 700; font-size: 0.95rem;">View All <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i></a>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: var(--bg-light);">
                    <th style="padding: 1.25rem 2.5rem; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Order ID</th>
                    <th style="padding: 1.25rem 2.5rem; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Date</th>
                    <th style="padding: 1.25rem 2.5rem; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Total</th>
                    <th style="padding: 1.25rem 2.5rem; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Status</th>
                    <th style="padding: 1.25rem 2.5rem; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_orders as $order)
                <tr style="border-bottom: 1px solid var(--border-soft);">
                    <td style="padding: 1.5rem 2.5rem; font-weight: 700;">#{{ $order->order_number ?? $order->id }}</td>
                    <td style="padding: 1.5rem 2.5rem; color: var(--text-muted);">{{ $order->created_at->format('M d, Y') }}</td>
                    <td style="padding: 1.5rem 2.5rem; font-weight: 700; color: var(--primary);">{{ $settings['site_currency_symbol'] ?? '₹' }}{{ number_format($order->total_amount, 2) }}</td>
                    <td style="padding: 1.5rem 2.5rem;">
                        <span style="padding: 0.5rem 1rem; border-radius: 30px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; 
                            @if($order->status == 'completed') background: rgba(34, 197, 94, 0.1); color: #22c55e;
                            @elseif($order->status == 'pending') background: rgba(245, 158, 11, 0.1); color: #f59e0b;
                            @else background: var(--bg-light); color: var(--text-muted); @endif">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td style="padding: 1.5rem 2.5rem;">
                        <a href="{{ route('customer.orders') }}" class="btn" style="padding: 0.5rem 1rem; font-size: 0.85rem; background: var(--bg-light); border: 1px solid var(--border-soft);">Details</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 4rem; text-align: center; color: var(--text-muted);">
                        <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.2;"></i><br>
                        No orders found yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
