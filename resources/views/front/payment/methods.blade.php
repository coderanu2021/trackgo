@extends('layouts.front')

@section('title', 'Payment Methods - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<div class="container" style="padding: 4rem 0;">
    <div style="margin-bottom: 3rem; text-align: center;">
        <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem; font-family: 'Outfit', sans-serif; font-weight: 800;">Choose Payment Method</h1>
        <p style="color: var(--text-muted); font-size: 1.1rem;">Select your preferred payment option to complete your order</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 4rem; align-items: flex-start;">
        <!-- Payment Methods -->
        <div>
            <form action="{{ route('payment.initiate', $order) }}" method="POST" id="payment-form">
                @csrf
                <div class="payment-methods">
                    @forelse($gateways as $gateway)
                        <div class="payment-method" data-gateway="{{ $gateway['slug'] }}">
                            <input type="radio" name="gateway" value="{{ $gateway['slug'] }}" id="gateway_{{ $gateway['slug'] }}" required>
                            <label for="gateway_{{ $gateway['slug'] }}" class="payment-method-card">
                                <div class="payment-method-header">
                                    @if($gateway['logo'])
                                        <img src="{{ asset($gateway['logo']) }}" alt="{{ $gateway['display_name'] }}" class="payment-logo">
                                    @else
                                        <div class="payment-icon">
                                            <i class="fas fa-{{ $gateway['slug'] === 'razorpay' ? 'credit-card' : ($gateway['slug'] === 'paypal' ? 'paypal' : 'money-check-alt') }}"></i>
                                        </div>
                                    @endif
                                    <div class="payment-info">
                                        <h3>{{ $gateway['display_name'] }}</h3>
                                        <p>{{ $gateway['description'] ?? 'Secure payment processing' }}</p>
                                    </div>
                                    <div class="payment-check">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                                @if($gateway['is_test_mode'])
                                    <div class="test-mode-badge">Test Mode</div>
                                @endif
                            </label>
                        </div>
                    @empty
                        <div class="no-payment-methods">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h3>No Payment Methods Available</h3>
                            <p>Please contact support to complete your order.</p>
                        </div>
                    @endforelse
                </div>

                @if(count($gateways) > 0)
                    <div style="margin-top: 3rem; text-align: center;">
                        <button type="submit" class="btn btn-primary btn-large">
                            <i class="fas fa-lock"></i> Proceed to Payment
                        </button>
                    </div>
                @endif
            </form>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <div style="background: white; padding: 2.5rem; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
                <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 2rem; color: var(--secondary);">Order Summary</h3>
                
                <div class="order-details">
                    <div class="order-row">
                        <span>Order ID:</span>
                        <span style="font-weight: 700;">#{{ $order->id }}</span>
                    </div>
                    <div class="order-row">
                        <span>Customer:</span>
                        <span>{{ $order->customer_name }}</span>
                    </div>
                    <div class="order-row">
                        <span>Email:</span>
                        <span>{{ $order->customer_email }}</span>
                    </div>
                    <div class="order-row">
                        <span>Items:</span>
                        <span>{{ $order->items->count() }} item(s)</span>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--border); margin: 2rem 0; padding-top: 2rem;">
                    <div class="order-row total-row">
                        <span style="font-size: 1.25rem; font-weight: 800;">Total Amount:</span>
                        <span style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <div style="background: var(--bg-light); padding: 1.5rem; border-radius: 12px; margin-top: 2rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; color: var(--text-muted); font-size: 0.9rem;">
                        <i class="fas fa-shield-alt" style="color: var(--success);"></i>
                        <span>Your payment information is secured with 256-bit SSL encryption</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .payment-method {
        position: relative;
    }

    .payment-method input[type="radio"] {
        display: none;
    }

    .payment-method-card {
        display: block;
        background: white;
        border: 2px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .payment-method-card:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
    }

    .payment-method input[type="radio"]:checked + .payment-method-card {
        border-color: var(--primary);
        background: rgba(243, 112, 33, 0.05);
        box-shadow: var(--shadow-primary);
    }

    .payment-method-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .payment-logo {
        width: 60px;
        height: 40px;
        object-fit: contain;
    }

    .payment-icon {
        width: 60px;
        height: 40px;
        background: var(--primary);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .payment-info h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: var(--secondary);
    }

    .payment-info p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin: 0;
    }

    .payment-check {
        margin-left: auto;
        width: 24px;
        height: 24px;
        border: 2px solid var(--border);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: transparent;
        transition: all 0.3s ease;
    }

    .payment-method input[type="radio"]:checked + .payment-method-card .payment-check {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .test-mode-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--warning);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .order-details {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .order-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.95rem;
    }

    .total-row {
        font-size: 1.1rem !important;
    }

    .no-payment-methods {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-muted);
    }

    .no-payment-methods i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--warning);
    }

    .btn-large {
        padding: 1.25rem 3rem;
        font-size: 1.1rem;
        font-weight: 700;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container > div:nth-child(2) {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .payment-method-header {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .payment-check {
            margin: 0;
        }
    }
</style>
@endsection