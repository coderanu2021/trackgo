@extends('layouts.front')

@section('title', 'Test Layout - Categories and Footer')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div class="card">
        <h2>Testing Layout Changes</h2>
        <p>This page is to test:</p>
        <ul>
            <li>Footer background image from Zenis template</li>
            <li>Dynamic categories in search bar (including subcategories)</li>
            <li>Category dropdown in navigation</li>
        </ul>
        
        <h3>Categories Available:</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1rem;">
            @foreach($categories_global as $category)
                @if($category->parent_id == null)
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px;">
                        <h4 style="color: var(--primary); margin-bottom: 0.5rem;">{{ $category->name }}</h4>
                        @if($category->children->count() > 0)
                            <ul style="margin: 0; padding-left: 1rem;">
                                @foreach($category->children as $child)
                                    <li style="margin-bottom: 0.25rem;">{{ $child->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p style="color: #666; font-size: 0.9rem; margin: 0;">No subcategories</p>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection