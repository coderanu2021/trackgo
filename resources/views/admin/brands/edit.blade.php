@extends('layouts.admin')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.brands.index') }}" style="color: var(--text-muted); font-weight: 600; font-size: 0.9rem;">
            <i class="fas fa-arrow-left"></i> Back to Brands
        </a>
        <h2 style="font-size: 1.75rem; font-weight: 800; color: var(--text-main); margin-top: 0.5rem;">Edit Brand</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 2rem;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <div class="col-12">
                    <label class="form-label">Brand Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name', $brand->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Brand Logo</label>
                    <div class="mb-3">
                        <img src="{{ asset($brand->logo) }}" alt="Current Logo" style="height: 60px; border: 1px solid var(--border); padding: 5px; border-radius: 4px;">
                    </div>
                    <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*,.svg">
                    <div class="form-text">Leave empty to keep current logo. Formats: PNG, JPG, GIF, SVG.</div>
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Website URL (Optional)</label>
                    <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $brand->url) }}">
                    @error('url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', $brand->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active Status</label>
                    </div>
                </div>

                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                        <i class="fas fa-save"></i> Update Brand
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
