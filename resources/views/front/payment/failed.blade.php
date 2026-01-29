@extends('layouts.front')

@section('title', 'Payment Failed - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<div class="container" style="padding: 6rem 0; text-align: center;">
    <div style="max-width: 600px; margin: 0 auto;">
        <div style="width: 100px; height: 100px; background: var(--error); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; color: white; font-size: 3rem;">
            <i class="fas fa-times"></i>
        </div>
        
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--error); font-family: 'Outfit', sans-serif; font-weight: 800;">Payment Failed</h1>
        
        <p style="font-size: 1.2rem; color: var(--text-muted); margin-bottom: 3rem; line-height: 1.6;">
            We're sorry, but your payment could not be processed. Please try again or use a different payment method.
        </p>

        @if(session('error'))
            <div style="background: rgba(239, 68, 68, 0.1); color: var(--error); padding: 1.5rem; border-radius: var(--radius-md); margin-bottom: 3rem; border-left: 4px solid var(--error);">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        @endif

        <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 2.5rem; margin-bottom: 3rem; text-align: left;">
            <h3 style="margin-bottom: 1.5rem; color: var(--secondary);">Order Details</h3>
            
            <div class="detail-row">
                <span>Order ID:</span>
                <span style="font-weight: 700;">#{{ $payment->order->id }}</span>
            </div>
            
            <div class="detail-row">
                <span>Amount:</span>
                <span style="font-weight: 700;">₹{{ number_format($payment->amount, 2) }}</span>
            </div>
            
            <div class="detail-row">
                <span>Payment Method:</span>
                <span style="font-weight: 700;">{{ ucfirst($payment->gateway) }}</span>
            </div>
            
            <div class="detail-row">
                <span>Status:</span>
                <span style="font-weight: 700; color: var(--error);">{{ ucfirst($payment->status) }}</span>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('payment.methods', $payment->order) }}" class="btn btn-primary">
                <i class="fas fa-redo"></i> Try Again
            </a>
            
            <a href="{{ route('home') }}" class="btn btn-secondary">
                <i class="fas fa-home"></i> Back to Home
            </a>
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