@extends('layouts.front')

@section('content')
<div class="container" style="padding: 6rem 0;">
    <div style="margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 0.5rem;">Secure Settlement</h1>
        <p style="color: var(--text-muted); font-size: 1.1rem;">Finalize your acquisition via our encrypted gateway.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 4rem; align-items: flex-start;">
        <!-- Checkout Form -->
        <div style="background: white; padding: 3rem; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
            <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-id-card-clip" style="color: var(--primary);"></i> Client Identification
            </h3>
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label style="display:block; margin-bottom: 0.65rem; font-weight: 700; font-size: 0.85rem; color: var(--secondary);">FULL NAME</label>
                        <input type="text" name="customer_name" required style="width:100%; padding:0.875rem 1.25rem; border: 1px solid var(--border); border-radius:12px; outline: none; background: var(--bg-light); box-sizing: border-box;" placeholder="Alexander Pierce">
                    </div>
                    <div class="form-group">
                        <label style="display:block; margin-bottom: 0.65rem; font-weight: 700; font-size: 0.85rem; color: var(--secondary);">EMAIL ADDRESS</label>
                        <input type="email" name="customer_email" required style="width:100%; padding:0.875rem 1.25rem; border: 1px solid var(--border); border-radius:12px; outline: none; background: var(--bg-light); box-sizing: border-box;" placeholder="alex@creatives.com">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display:block; margin-bottom: 0.65rem; font-weight: 700; font-size: 0.85rem; color: var(--secondary);">PHONE NUMBER</label>
                    <input type="text" name="customer_phone" required style="width:100%; padding:0.875rem 1.25rem; border: 1px solid var(--border); border-radius:12px; outline: none; background: var(--bg-light); box-sizing: border-box;" placeholder="+1 (555) 000-0000">
                </div>

                <div class="form-group" style="margin-bottom: 2.5rem;">
                    <label style="display:block; margin-bottom: 0.65rem; font-weight: 700; font-size: 0.85rem; color: var(--secondary);">SHIPPING DESTINATION</label>
                    <textarea name="shipping_address" required rows="4" style="width:100%; padding:0.875rem 1.25rem; border: 1px solid var(--border); border-radius:12px; outline: none; background: var(--bg-light); resize: none; box-sizing: border-box;" placeholder="Complete street address, city, and postal code..."></textarea>
                </div>

                <div style="background: var(--bg-light); padding: 1.5rem; border-radius: 12px; margin-bottom: 2.5rem; border: 1px dashed var(--border);">
                    <div style="display: flex; gap: 1rem; align-items: center; color: var(--text-muted); font-size: 0.9rem;">
                        <i class="fas fa-lock" style="font-size: 1.25rem; color: #10b981;"></i>
                        <span>Payment processing is secured by bank-grade encryption of the Pulse Protocol. Your data remains private.</span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; padding: 1.25rem; font-size: 1.1rem; justify-content: center;">
                    Confirm & Authorize Order
                </button>
            </form>
        </div>

        <!-- Order Summary Column -->
        <aside>
            <div style="background: var(--secondary); color: white; padding: 2.5rem; border-radius: var(--radius-lg); position: sticky; top: 120px;">
                <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">Order Dossier</h3>
                @php $total = 0 @endphp
                <div style="margin-bottom: 2rem;">
                    @foreach($cart as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <div class="flex justify-between items-center" style="margin-bottom: 1.25rem; font-size: 0.95rem;">
                            <div style="max-width: 200px;">
                                <div style="font-weight: 600;">{{ $details['title'] }}</div>
                                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.5);">QTY: {{ $details['quantity'] }}</div>
                            </div>
                            <div style="font-family: 'Outfit', sans-serif; font-weight: 700;">₹{{ number_format($details['price'] * $details['quantity'], 2) }}</div>
                        </div>
                    @endforeach
                </div>

                <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem;">
                    <div class="flex justify-between" style="margin-bottom: 0.75rem; font-size: 0.9rem; color: rgba(255,255,255,0.6);">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between" style="margin-bottom: 0.75rem; font-size: 0.9rem; color: rgba(255,255,255,0.6);">
                        <span>Processing Fee</span>
                        <span style="color: #10b981;">FREE</span>
                    </div>
                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between; font-weight: 800; font-size: 1.5rem;">
                        <span>Final Total</span>
                        <span style="color: var(--primary);">₹{{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <div style="text-align: center; font-size: 0.8rem; color: rgba(255,255,255,0.4);">
                    <i class="fas fa-check-double"></i> Verified High-Value Transaction
                </div>
            </div>
        </aside>
    </div>
</div>

<style>
    /* Responsive Checkout Styles */
    @media (max-width: 1024px) {
        .container > div:nth-child(2) {
            grid-template-columns: 1fr 350px;
            gap: 3rem;
        }
    }
    
    @media (max-width: 768px) {
        .container {
            padding: 3rem 1rem !important;
        }
        
        .container > div:nth-child(2) {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        /* Form responsive */
        .container > div:nth-child(2) > div:first-child {
            padding: 2rem !important;
        }
        
        .container > div:nth-child(2) > div:first-child > form > div:first-child {
            grid-template-columns: 1fr !important;
            gap: 1rem;
        }
        
        /* Order summary responsive */
        aside > div {
            position: static !important;
            padding: 2rem !important;
        }
        
        /* Order items responsive */
        aside > div > div:nth-child(2) > div {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 0.5rem;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        aside > div > div:nth-child(2) > div:last-child {
            border-bottom: none;
        }
        
        aside > div > div:nth-child(2) > div > div:last-child {
            align-self: flex-end;
            font-size: 1.1rem;
        }
        
        /* Form inputs full width */
        input, textarea, select {
            width: 100% !important;
            box-sizing: border-box;
        }
        
        /* Button full width */
        button[type="submit"] {
            width: 100% !important;
        }
    }
    
    @media (max-width: 480px) {
        h1 {
            font-size: 2rem !important;
        }
        
        .container > div:nth-child(2) > div:first-child {
            padding: 1.5rem !important;
        }
        
        aside > div {
            padding: 1.5rem !important;
        }
        
        /* Form inputs prevent zoom on iOS */
        input, textarea, select {
            font-size: 16px !important;
        }
        
        /* Smaller form elements */
        .form-group {
            margin-bottom: 1rem;
        }
        
        /* Order summary items */
        aside > div > div:nth-child(2) > div > div:first-child {
            max-width: 100%;
        }
        
        /* Total section */
        aside > div > div:nth-child(3) {
            padding: 1rem !important;
        }
        
        aside > div > div:nth-child(3) > div:last-child {
            font-size: 1.25rem !important;
        }
    }
    
    /* Additional mobile improvements */
    @media (max-width: 640px) {
        /* Security notice */
        .container > div:nth-child(2) > div:first-child > form > div:nth-child(4) {
            padding: 1rem !important;
            font-size: 0.85rem;
        }
        
        /* Order summary header */
        aside > div > h3 {
            font-size: 1.1rem !important;
        }
        
        /* Responsive grid for name/email */
        .container > div:nth-child(2) > div:first-child > form > div:first-child {
            display: block !important;
        }
        
        .container > div:nth-child(2) > div:first-child > form > div:first-child > div {
            margin-bottom: 1rem;
        }
        
        .container > div:nth-child(2) > div:first-child > form > div:first-child > div:last-child {
            margin-bottom: 0;
        }
    }
</style>
@endsection
