@extends('layouts.front')

@section('content')
<div class="container" style="padding: 6rem 0;">
    <div style="margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 0.5rem;">Your Selection</h1>
        <p style="color: var(--text-muted); font-size: 1.1rem;">Review your premium choices before checkout.</p>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); color: #065f46; padding: 1.25rem 1.5rem; border-radius: var(--radius-md); margin-bottom: 2.5rem; border-left: 4px solid #10b981; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
             <i class="fas fa-circle-check" style="color: #10b981;"></i> {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; box-shadow: var(--shadow-md);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--bg-light); border-bottom: 1px solid var(--border); text-align: left;">
                    <th style="padding: 1.5rem 2rem; font-weight: 700; color: var(--secondary); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Product Details</th>
                    <th style="padding: 1.5rem; font-weight: 700; color: var(--secondary); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Price</th>
                    <th style="padding: 1.5rem; font-weight: 700; color: var(--secondary); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Quantity</th>
                    <th style="padding: 1.5rem; font-weight: 700; color: var(--secondary); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Total</th>
                    <th style="padding: 1.5rem 2rem; text-align: right;"></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @forelse($cart as $id => $details)
                    @php $total += $details['price'] * $details['quantity'] @endphp
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 2rem;">
                            <div style="display: flex; align-items: center; gap: 1.5rem;">
                                <div style="width: 80px; height: 80px; background: var(--bg-light); border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid var(--border);">
                                    <img src="{{ $details['image'] }}" style="max-width: 100%; height: auto; object-fit: cover;">
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: var(--secondary); font-size: 1.1rem; margin-bottom: 0.25rem;">{{ $details['title'] }}</div>
                                    <div style="font-size: 0.85rem; color: var(--text-muted);">SKU: {{ substr(md5($id), 0, 8) }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 2rem; font-family: 'Outfit', sans-serif; font-weight: 700; color: var(--secondary);">${{ number_format($details['price'], 2) }}</td>
                        <td style="padding: 2rem;">
                            <input type="number" value="{{ $details['quantity'] }}" class="quantity-input" data-id="{{ $id }}" 
                                   style="width: 70px; padding: 0.65rem; border: 1px solid var(--border); border-radius: 10px; outline: none; transition: 0.3s; font-weight: 600; text-align: center;"
                                   onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        </td>
                        <td style="padding: 2rem; font-family: 'Outfit', sans-serif; font-weight: 800; color: var(--primary); font-size: 1.15rem;">${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                        <td style="padding: 2rem; text-align: right;">
                            <button class="btn remove-from-cart" data-id="{{ $id }}" style="background: rgba(239, 68, 68, 0.05); color: #ef4444; width: 45px; height: 45px; justify-content: center; padding: 0; border-radius: 12px; transition: 0.3s;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 5rem; text-align: center;">
                            <i class="fas fa-shopping-bag" style="font-size: 3rem; color: var(--border); margin-bottom: 1.5rem; display: block;"></i>
                            <div style="font-weight: 700; color: var(--secondary); font-size: 1.25rem;">Your collection is empty.</div>
                            <p style="color: var(--text-muted); margin-top: 0.5rem;">Explore our store to add premium items.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="padding: 3rem; background: var(--bg-light); border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ url('/') }}" class="btn" style="background: white; border: 1px solid var(--border); color: var(--secondary);">
                <i class="fas fa-arrow-left"></i> Background Explore
            </a>
            <div style="text-align: right;">
                <div style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0.5rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Grand Total</div>
                <div style="font-family: 'Outfit', sans-serif; font-size: 2.5rem; font-weight: 800; color: var(--secondary); margin-bottom: 2rem;">${{ number_format($total, 2) }}</div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="padding: 1.15rem 3rem; font-size: 1.1rem; box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);">
                    Proceed to Settlement <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(".quantity-input").change(function (e) {
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: '{{ route('cart.update') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}', 
                id: ele.attr("data-id"), 
                quantity: ele.val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        if(confirm("Are you sure you want to remove?")) {
            $.ajax({
                url: '{{ route('cart.remove') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
</script>
@endsection
