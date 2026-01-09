@extends('layouts.admin')

@section('content')
<h1>Edit Category</h1>

<form action="{{ route('admin.categories.update', $category->id) }}" method="POST" style="max-width:600px;">
    @csrf
    @method('PUT')
    <div class="glass" style="padding:2rem;">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-input" value="{{ $category->name }}" required>
        </div>
        <div class="form-group">
            <label>Image URL (Optional)</label>
            <input type="text" name="image" class="form-input" value="{{ $category->image }}">
        </div>
        <div class="form-group">
            <label>Icon Class (Optional)</label>
            <input type="text" name="icon" class="form-input" value="{{ $category->icon }}">
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" {{ $category->is_active ? 'checked' : '' }}> Active
            </label>
        </div>
        <button type="submit" class="btn-primary">Update Category</button>
    </div>
</form>
@endsection
