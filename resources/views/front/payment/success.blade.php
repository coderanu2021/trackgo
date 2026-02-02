@extends('layouts.front')

@section('title', 'Payment Successful - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<div class="container" style="padding: 6rem 0; text-align: center;">
    <div style="max-width: 600px; margin: 0 auto;">
        <div style="width: 100px; height: 100px; background: var(--success); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; color: white; font-size: 3rem;">
            <i class="fas fa-check"></i>
        </div>
        
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--success); font-family: 'Outfit', sans-serif; font-weight: 800;">Payment Successful!</h1>
        
        <p style="font-size: 1.2rem; color: var(--text-muted); margin-bottom: 3rem; line-height: 1.6;">
            Thank you for your payment. Your order has been confirmed and will be processed shortly.
        </p>

        <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 2.5rem; margin-bottom: 3rem; text-align: left;">
            <h3 style="margin-bottom: 1.5rem; color: var(--secondary);">Payment Details</h3>
            
            <div class="detail-row">
                <span>Payment ID:</span>
                <span style="font-weight: 700;">{{ $payment->payment_id }}</span>
            </div>
            
            <div class="detail-row">
                <span>Order ID:</span>
                <span style="font-weight: 700;">#{{ $payment->order->id }}</span>
            </div>
            
            <div class="detail-row">
                <span>Amount Paid:</span>
                <span style="font-weight: 700; color: var(--success);">₹{{ formatIndianPrice($payment->amount, 2) }}</span>
            </div>
            
            <div class="detail-row">
                <span>Payment Method:</span>
                <span style="font-weight: 700;">{{ ucfirst($payment->gateway) }}</span>
            </div>
            
            <div class="detail-row">
                <span>Payment Date:</span>
                <span style="font-weight: 700;">{{ $payment->paid_at ? $payment->paid_at->format('M d, Y h:i A') : 'Just now' }}</span>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-home"></i> Continue Shopping
            </a>
            
            @auth
                <a href="{{ route('customer.orders') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> View Orders
                </a>
            @endauth
        </div>
    </div>
</div>

<style>
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border);
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    @media (max-width: 768px) {
        .container {
            padding: 3rem 1rem !important;
        }
        
        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
    }
</style>
@endsection