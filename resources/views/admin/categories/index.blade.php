@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center" style="margin-bottom:2rem;">
    <h1>Product Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">Add New Category</a>
</div>

<div class="glass">
    <table class="w-full">
        <thead>
            <tr style="text-align:left;">
                <th style="padding:1rem;">Name</th>
                <th style="padding:1rem;">Slug</th>
                <th style="padding:1rem;">Active</th>
                <th style="padding:1rem;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr style="border-top:1px solid #eee;">
                <td style="padding:1rem;">{{ $category->name }}</td>
                <td style="padding:1rem;">{{ $category->slug }}</td>
                <td style="padding:1rem;">{{ $category->is_active ? 'Yes' : 'No' }}</td>
                <td style="padding:1rem;">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" style="color:blue; margin-right:1rem;">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color:red; background:none; border:none; cursor:pointer;">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
