# Admin Forms Standardization Guide

## 📋 Overview

All admin forms now follow a standardized structure with:
- ✅ Publish/Save buttons at the bottom of the page
- ✅ Sticky bottom action bar
- ✅ Consistent styling across all forms
- ✅ Responsive design
- ✅ Reusable components

## 🎨 Implementation

### 1. Include Required CSS

Add to your admin layout (`resources/views/layouts/admin.blade.php`):

```html
<link rel="stylesheet" href="{{ asset('css/admin-forms.css') }}">
```

### 2. Form Structure

```html
<div class="admin-content">
    <div class="admin-header">
        <div>
            <h1>Page Title</h1>
            <p>Page description</p>
        </div>
        <!-- NO BUTTONS HERE - They will be hidden by CSS -->
    </div>

    <form id="my-form" method="POST" action="{{ route('...') }}">
        @csrf
        
        <!-- Form Section 1 -->
        <div class="form-section">
            <h3 class="form-section-title">
                <i class="fas fa-info-circle"></i>
                Basic Information
            </h3>
            
            <div class="form-group">
                <label for="title" class="required">Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
                <span class="form-help">Enter a descriptive title</span>
            </div>
            
            <!-- More fields... -->
        </div>

        <!-- Form Section 2 -->
        <div class="form-section">
            <h3 class="form-section-title">
                <i class="fas fa-image"></i>
                Images
            </h3>
            
            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" id="image" name="image" class="form-control">
                <span class="image-size-hint">
                    <i class="fas fa-info-circle"></i>
                    Recommended: 1200x900px (4:3 ratio, max 2MB)
                </span>
            </div>
        </div>

        <!-- More sections... -->
    </form>

    <!-- Bottom Action Bar -->
    @include('admin.components.form-actions', [
        'formId' => 'my-form',
        'submitText' => 'Save Product',
        'cancelRoute' => route('admin.products.index'),
        'showPreview' => false
    ])
</div>
```

### 3. Form Actions Component

The `form-actions` component accepts these parameters:

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `formId` | string | 'main-form' | ID of the form to submit |
| `submitText` | string | 'Save Changes' | Text for submit button |
| `cancelRoute` | string | previous URL | URL for cancel button |
| `showPreview` | boolean | false | Show preview button |
| `previewRoute` | string | null | URL for preview |

### 4. Form Sections

Use `.form-section` for grouping related fields:

```html
<div class="form-section">
    <h3 class="form-section-title">
        <i class="fas fa-icon-name"></i>
        Section Title
    </h3>
    
    <!-- Form fields here -->
</div>
```

### 5. Form Groups

Standard form field structure:

```html
<div class="form-group">
    <label for="field-id" class="required">Field Label</label>
    <input type="text" id="field-id" name="field_name" class="form-control" required>
    <span class="form-help">Help text for the user</span>
    <span class="form-hint">Additional hint or example</span>
</div>
```

### 6. Image Upload with Size Hint

```html
<div class="form-group">
    <label for="image">Product Image</label>
    <input type="file" id="image" name="image" class="form-control" accept="image/*">
    <span class="image-size-hint">
        <i class="fas fa-info-circle"></i>
        Recommended: 1200x900px (4:3 ratio, max 2MB)
    </span>
    
    @if(isset($product) && $product->image)
        <div class="image-preview">
            <img src="{{ asset($product->image) }}" alt="Current image">
        </div>
    @endif
</div>
```

### 7. Checkbox/Toggle

```html
<div class="form-check">
    <input type="checkbox" id="is_active" name="is_active" value="1" checked>
    <label for="is_active">
        <strong>Active</strong>
        <span class="form-help">Make this item visible on the website</span>
    </label>
</div>
```

### 8. Grid Layouts

For side-by-side fields:

```html
<div class="form-grid-2">
    <div class="form-group">
        <label>Field 1</label>
        <input type="text" class="form-control">
    </div>
    
    <div class="form-group">
        <label>Field 2</label>
        <input type="text" class="form-control">
    </div>
</div>
```

## 📐 Image Size Reference

Quick reference for image size hints:

```html
<!-- Product Hero Image -->
<span class="image-size-hint">
    <i class="fas fa-info-circle"></i>
    1200x900px (4:3 ratio, max 2MB)
</span>

<!-- Category Icon -->
<span class="image-size-hint">
    <i class="fas fa-info-circle"></i>
    400x400px (1:1 ratio, max 512KB)
</span>

<!-- Category Banner -->
<span class="image-size-hint">
    <i class="fas fa-info-circle"></i>
    1920x400px (16:3.5 ratio, max 2MB) - Root categories only
</span>

<!-- Gallery Image -->
<span class="image-size-hint">
    <i class="fas fa-info-circle"></i>
    1200x900px (4:3 ratio, max 2MB)
</span>

<!-- Home Banner -->
<span class="image-size-hint">
    <i class="fas fa-info-circle"></i>
    1920x600px (16:5 ratio, max 3MB)
</span>

<!-- Brand Logo -->
<span class="image-size-hint">
    <i class="fas fa-info-circle"></i>
    300x150px (2:1 ratio, max 512KB)
</span>
```

## 🎯 Benefits

1. **Consistency**: All forms look and behave the same
2. **User-Friendly**: Actions always in the same place
3. **Mobile-Responsive**: Works on all screen sizes
4. **Easy to Maintain**: Change once, applies everywhere
5. **Professional**: Clean, modern design

## 🔧 Customization

### Change Button Colors

Edit `public/css/admin-forms.css`:

```css
.btn-primary {
    background: var(--primary);
    color: white;
}
```

### Adjust Sticky Bar Position

```css
.form-actions-bottom {
    bottom: 0; /* Change this value */
}
```

### Modify Section Spacing

```css
.form-section {
    margin-bottom: 1.5rem; /* Adjust spacing */
}
```

## 📝 Example Forms

### Product Create Form

```html
<form id="product-form" method="POST" action="{{ route('admin.products.store') }}">
    @csrf
    
    <div class="form-section">
        <h3 class="form-section-title">
            <i class="fas fa-box"></i>
            Product Information
        </h3>
        
        <div class="form-group">
            <label for="title" class="required">Product Title</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="summary">Short Summary</label>
            <textarea id="summary" name="summary" class="form-textarea" rows="3"></textarea>
            <span class="form-help">Brief description (200-300 characters recommended)</span>
        </div>
        
        <div class="form-grid-2">
            <div class="form-group">
                <label for="price">Price (₹)</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01">
                <span class="form-hint">Leave empty for "Enquire Now" products</span>
            </div>
            
            <div class="form-group">
                <label for="stock">Stock Quantity</label>
                <input type="number" id="stock" name="stock" class="form-control" value="0">
            </div>
        </div>
    </div>
    
    <div class="form-section">
        <h3 class="form-section-title">
            <i class="fas fa-image"></i>
            Product Image
        </h3>
        
        <div class="form-group">
            <label for="hero_image">Main Image</label>
            <input type="file" id="hero_image" name="hero_image" class="form-control" accept="image/*">
            <span class="image-size-hint">
                <i class="fas fa-info-circle"></i>
                1200x900px (4:3 ratio, max 2MB)
            </span>
        </div>
    </div>
</form>

@include('admin.components.form-actions', [
    'formId' => 'product-form',
    'submitText' => 'Create Product',
    'cancelRoute' => route('admin.products.index')
])
```

## ✅ Migration Checklist

To update existing forms:

- [ ] Add `admin-forms.css` to admin layout
- [ ] Remove top submit buttons from forms
- [ ] Add form ID to `<form>` tag
- [ ] Wrap content in `.form-section` divs
- [ ] Add `.form-group` to each field
- [ ] Add image size hints to file inputs
- [ ] Include `form-actions` component at bottom
- [ ] Test on mobile devices
- [ ] Verify all buttons work correctly

---

**Created**: February 22, 2026  
**Version**: 1.0  
**Status**: Ready for implementation
