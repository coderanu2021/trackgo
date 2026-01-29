@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">Order Registry</h1>
        <p style="color: var(--text-muted); font-size: 1rem;">Historical and active transaction tracking.</p>
    </div>
</div>

<div class="table-container">
    <table id="orders-table">
        <thead>
            <tr>
                <th>Order Ref</th>
                <th>Purchaser Detail</th>
                <th>Gross Value</th>
                <th>Voucher Status</th>
                <th>Timestamp</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td style="font-weight: 800; color: var(--primary);">#{{ $order->id }}</td>
                <td>
                    <div style="font-weight: 700; color: var(--text-main);">{{ $order->customer_name }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-light);">{{ $order->customer_email }}</div>
                </td>
                <td>
                    <div style="font-weight: 800; color: var(--text-main); font-size: 1.05rem;">₹{{ number_format($order->total_amount, 2) }}</div>
                </td>
                <td>
                    <span class="badge" style="background: {{ $order->status == 'completed' ? 'rgba(16,185,129,0.1)' : ( $order->status == 'pending' ? 'rgba(59,130,246,0.1)' : 'rgba(239, 68, 68, 0.1)' ) }};
                                          color: {{ $order->status == 'completed' ? '#065f46' : ($order->status == 'pending' ? '#075985' : '#991b1b') }};">
                        {{ strtoupper($order->status) }}
                    </span>
                </td>
                <td style="color: var(--text-light); font-weight: 600;">{{ $order->created_at->format('M d, Y') }}</td>
                <td style="text-align: right;">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn" style="background: var(--bg-main); color: var(--text-muted); width: 40px; height: 40px; justify-content: center; padding: 0; border-radius: 10px;">
                        <i class="fas fa-arrow-right-long"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#orders-table').DataTable({
        "pageLength": 10,
        "ordering": true,
        "info": true,
        "order": [[0, "desc"]],
        "language": {
            "search": "",
            "searchPlaceholder": "Search orders...",
            "paginate": {
                "previous": "<i class='fas fa-chevron-left'></i>",
                "next": "<i class='fas fa-chevron-right'></i>"
            }
        }
    });
});
</script>
@endsection
