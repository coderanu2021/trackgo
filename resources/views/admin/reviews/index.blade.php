@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">Product Reviews</h1>
        <p style="color: var(--text-muted); font-size: 1rem;">Moderate and manage feedback from your customers.</p>
    </div>
    <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary" style="padding: 0.875rem 2rem; border-radius: 14px;">
        <i class="fas fa-plus"></i> New Review
    </a>
</div>

<div class="table-container">
    <table id="reviews-table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Product</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Status</th>
                <th>Date</th>
                <th style="text-align: right;">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
            <tr>
                <td>
                    <div style="font-weight: 700; color: var(--text-main); font-size: 0.95rem;">{{ $review->name }}</div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $review->email }}</div>
                </td>
                <td style="max-width: 200px;">
                    <a href="{{ route('products.show', $review->product->slug) }}" target="_blank" style="color: var(--primary); font-weight: 600; text-decoration: none;">
                        {{ $review->product->title }}
                    </a>
                </td>
                <td>
                    <div style="color: #ffc107; font-size: 0.85rem;">
                        @for($i=1; $i<=5; $i++)
                            <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                        @endfor
                    </div>
                </td>
                <td style="max-width: 300px;">
                    <div style="font-size: 0.9rem; color: var(--text-main); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $review->comment }}
                    </div>
                </td>
                <td>
                    <form action="{{ route('admin.reviews.toggle', $review->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="badge" style="cursor: pointer; border: none; background: {{ $review->is_approved ? 'rgba(16,185,129,0.1)' : 'rgba(239, 68, 68, 0.1)' }};
                                              color: {{ $review->is_approved ? '#065f46' : '#991b1b' }};">
                            {{ $review->is_approved ? 'APPROVED' : 'PENDING' }}
                        </button>
                    </form>
                </td>
                <td style="color: var(--text-light); font-weight: 500;">{{ $review->created_at->format('M d, Y') }}</td>
                <td style="text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Erase this review?')" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.05); color: #ef4444; width: 40px; height: 40px; justify-content: center; padding: 0; border-radius: 10px;">
                                <i class="fas fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#reviews-table').DataTable({
        "pageLength": 10,
        "ordering": true,
        "info": true,
        "order": [[5, "desc"]],
        "language": {
            "search": "",
            "searchPlaceholder": "Search reviews...",
            "paginate": {
                "previous": "<i class='fas fa-chevron-left'></i>",
                "next": "<i class='fas fa-chevron-right'></i>"
            }
        }
    });
});
</script>
@endsection
