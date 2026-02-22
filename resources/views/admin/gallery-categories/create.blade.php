@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1>Add Gallery Category</h1>
        <p style="color: var(--text-muted);">Create a new category for organizing gallery images.</p>
    </div>
</div>

<form id="category-form" action="{{ route('admin.gallery-categories.store') }}" method="POST">
    @csrf
    
    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="max-width: 800px;">
        <div class="form-section-title">
            <i class="fas fa-folder"></i>
            Category Information
        </div>

        <div class="form-group">
            <label class="required">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" 
                   placeholder="e.g. Events, Products, Team" required>
            <span class="form-help">A descriptive name for this gallery category</span>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3" class="form-control" 
                      placeholder="Optional description for this category">{{ old('description') }}</textarea>
            <span class="form-help">Brief description of what images belong in this category</span>
        </div>

        <div class="form-group">
            <label>Display Order</label>
            <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" 
                   placeholder="0" min="0">
            <span class="form-help">Lower numbers appear first (0 = highest priority)</span>
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="is_active" id="is_active" value="1" 
                       {{ old('is_active', true) ? 'checked' : '' }}>
                <label for="is_active">Active (visible on frontend)</label>
            </div>
        </div>
    </div>
</form>

@include('admin.components.form-actions', [
    'formId' => 'category-form',
    'submitText' => 'Create Category',
    'cancelRoute' => route('admin.gallery-categories.index'),
    'showPreview' => false
])
@endsection
