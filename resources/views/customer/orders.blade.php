@extends('customer.layout')

@section('customer_content')
<div class="dashboard-header" style="margin-bottom: 3rem;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin: 0; font-family: 'Outfit';">My Orders</h1>
    <p style="color: var(--text-muted); margin-top: 0.5rem; font-size: 1.1rem;">Track and review all your previous purchases.</p>
</div>

<div class="card" style="background: var(--white); border-radius: 24px; box-shadow: var(--shadow-md); border: 1px solid var(--border-soft); overflow: hidden;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: var(--bg-light);">
                    <th style="padding: 1.25rem 2.5rem; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Order ID</th>
                    <th style="padding: 1.25rem 2.5rem; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Date</th>
                    <th style="padding: 1.25rem 2.5rem; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Total</th>
                    <th style="padding: 1.25rem 2.5rem; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Status</th>
                    <th style="padding: 1.25rem 2.5rem; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Payment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr style="border-bottom: 1px solid var(--border-soft);">
                    <td style="padding: 1.5rem 2.5rem; font-weight: 700;">#{{ $order->order_number ?? $order->id }}</td>
                    <td style="padding: 1.5rem 2.5rem; color: var(--text-muted);">{{ $order->created_at->format('M d, Y') }} - <small>{{ $order->created_at->format('h:i A') }}</small></td>
                    <td style="padding: 1.5rem 2.5rem; font-weight: 700; color: var(--primary);">{{ $settings['site_currency_symbol'] ?? '₹' }}{{ formatIndianPrice($order->total_amount, 2) }}</td>
                    <td style="padding: 1.5rem 2.5rem;">
                        <span style="padding: 0.5rem 1rem; border-radius: 30px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; 
                            @if($order->status == 'completed') background: rgba(34, 197, 94, 0.1); color: #22c55e;
                            @elseif($order->status == 'pending') background: rgba(245, 158, 11, 0.1); color: #f59e0b;
                            @elseif($order->status == 'processing') background: rgba(99, 102, 241, 0.1); color: #6366f1;
                            @else background: var(--bg-light); color: var(--text-muted); @endif">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td style="padding: 1.5rem 2.5rem;">
                        <span style="font-size: 0.9rem; font-weight: 600; color: var(--text-main);">{{ ucfirst($order->payment_status ?? 'paid') }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 6rem; text-align: center; color: var(--text-muted);">
                        <i class="fas fa-box-open" style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.1;"></i><br>
                        <span style="font-size: 1.25rem; font-weight: 600; display: block; margin-bottom: 0.5rem;">No historical data available.</span>
                        Start shopping to build your collection!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->count() > 0)
        <div style="padding: 2.5rem;">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
