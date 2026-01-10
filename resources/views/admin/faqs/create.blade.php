@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div>
        <h1>Add New FAQ</h1>
        <p>Create a new question and answer pair.</p>
    </div>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.faqs.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Category</label>
            <input type="text" name="category" class="form-control" placeholder="e.g. Billing">
        </div>

        <div class="form-group">
            <label>Question</label>
            <input type="text" name="question" class="form-control" placeholder="How do I...?" required>
        </div>

        <div class="form-group">
            <label>Answer</label>
            <textarea name="answer" class="form-control" rows="6" placeholder="Enter the detailed answer here..." required></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="0">
            </div>
            <div class="form-group flex items-end">
                <div class="form-check" style="margin-bottom: 0.75rem;">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                    <label for="is_active">Active</label>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Create FAQ</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
