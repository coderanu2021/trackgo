@extends('layouts.admin')

@section('content')
<div style="margin-bottom: 2.5rem;">
    <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">Add Manual Review</h1>
    <p style="color: var(--text-muted); font-size: 1rem;">Create a review on behalf of a customer.</p>
</div>

<div style="background: white; padding: 2.5rem; border-radius: 20px; box-shadow: var(--shadow-sm); border: 1px solid var(--border-soft); max-width: 800px;">
    <form action="{{ route('admin.reviews.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div class="form-group">
                <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-main);">Customer Name</label>
                <input type="text" name="name" class="form-control" placeholder="John Doe" required style="width: 100%; padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid var(--border); outline: none;">
            </div>
            <div class="form-group">
                <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-main);">Customer Email</label>
                <input type="email" name="email" class="form-control" placeholder="john@example.com" required style="width: 100%; padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid var(--border); outline: none;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div class="form-group">
                <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-main);">Product</label>
                <select name="page_id" class="form-control" required style="width: 100%; padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid var(--border); outline: none;">
                    <option value="">Select a product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-main);">Rating (1-5)</label>
                <select name="rating" class="form-control" required style="width: 100%; padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid var(--border); outline: none;">
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 2.5rem;">
            <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-main);">Review Comment</label>
            <textarea name="comment" rows="5" class="form-control" placeholder="Enter the review content..." required style="width: 100%; padding: 1rem; border-radius: 10px; border: 1px solid var(--border); outline: none; resize: none;"></textarea>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.875rem 2.5rem; border-radius: 12px; font-weight: 700;">
                <i class="fas fa-save" style="margin-right: 0.5rem;"></i> Save Review
            </button>
            <a href="{{ route('admin.reviews.index') }}" class="btn" style="padding: 0.875rem 2.5rem; border-radius: 12px; font-weight: 700; background: var(--bg-main); color: var(--text-main); border: 1px solid var(--border);">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
