@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div>
        <h1>Edit FAQ</h1>
        <p>Modify the question or answer details.</p>
    </div>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
        @csrf @method('PUT')
        
        <div class="form-group">
            <label>Category</label>
            <input type="text" name="category" class="form-control" value="{{ $faq->category }}" placeholder="e.g. Billing">
        </div>

        <div class="form-group">
            <label>Question</label>
            <input type="text" name="question" class="form-control" value="{{ $faq->question }}" required>
        </div>

        <div class="form-group">
            <label>Answer</label>
            <textarea name="answer" class="form-control" rows="6" required>{{ $faq->answer }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ $faq->sort_order }}">
            </div>
            <div class="form-group" style="display: flex; align-items: flex-end; padding-bottom: 0.75rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ $faq->is_active ? 'checked' : '' }}> Active
                </label>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Update FAQ</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
