@extends('layouts.admin')

@section('content')
<h1>Create Category</h1>

<form action="{{ route('admin.categories.store') }}" method="POST" style="max-width:600px;">
    @csrf
    <div class="glass" style="padding:2rem;">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-input" required>
        </div>
        <div class="form-group">
            <label>Image URL (Optional)</label>
            <input type="text" name="image" class="form-input">
        </div>
        <div class="form-group">
            <label>Icon Class (Optional)</label>
            <input type="text" name="icon" class="form-input" placeholder="fa fa-user">
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" checked> Active
            </label>
        </div>
        <button type="submit" class="btn-primary">Create Category</button>
    </div>
</form>
@endsection
