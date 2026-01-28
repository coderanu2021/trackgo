# Builder Separation Documentation

## Overview
The system now has two separate builders to avoid confusion:

## 1. PRODUCT BUILDER 🛍️
**Purpose**: E-commerce products with shopping functionality
**Controller**: `ProductController.php`
**Model**: `Page` (table: `pages`)
**Routes**: `/admin/products/*`

### Features:
- ✅ Price & Discount
- ✅ Stock Management
- ✅ Categories
- ✅ Shopping Cart Integration
- ✅ Product Gallery
- ✅ Reviews System
- ✅ SEO Fields

### Admin URLs:
- List: `/admin/products`
- Create: `/admin/products/create`
- Edit: `/admin/products/{id}/edit`

### Frontend URLs:
- Shop: `/shop`
- Single Product: `/products/{slug}`

---

## 2. PAGE BUILDER 📄
**Purpose**: General pages (About, Contact, Landing Pages)
**Controller**: `PageBuilderController.php`
**Model**: `ProductPage` (table: `product_pages`)
**Routes**: `/admin/pages/*`

### Features:
- ✅ Hero Images
- ✅ Block-based Content
- ✅ SEO Fields
- ✅ Publishing Status
- ❌ No Price/Stock
- ❌ No Cart Integration

### Admin URLs:
- List: `/admin/pages`
- Create: `/admin/pages/create`
- Edit: `/admin/pages/{id}/edit`

### Frontend URLs:
- General Page: `/pages/{slug}`

---

## Key Differences

| Feature | Product Builder | Page Builder |
|---------|----------------|--------------|
| **Purpose** | E-commerce Products | General Pages |
| **Price** | ✅ Yes | ❌ No |
| **Stock** | ✅ Yes | ❌ No |
| **Cart** | ✅ Yes | ❌ No |
| **Categories** | ✅ Yes | ❌ No |
| **Reviews** | ✅ Yes | ❌ No |
| **Hero Image** | ❌ No | ✅ Yes |
| **Block Content** | ✅ Yes | ✅ Yes |

---

## Database Tables

### `pages` (Products)
```sql
- id, title, slug, content (JSON)
- price, discount, stock
- category_id, thumbnail, gallery (JSON)
- is_active, is_enquiry
- meta_title, meta_description, meta_keywords
```

### `product_pages` (General Pages)
```sql
- id, title, slug, content (JSON)
- hero_image, is_published
- meta_title, meta_description, meta_keywords
```

---

## Usage Examples

### Creating a Product (T-Shirt):
1. Go to `/admin/products/create`
2. Set price: $29.99
3. Set stock: 50
4. Choose category: Fashion
5. Add product images
6. Build content with blocks

### Creating a Page (About Us):
1. Go to `/admin/pages/create`
2. Set hero image
3. Build content with blocks
4. No price/stock needed

This separation makes it clear:
- **Products** = Things you sell
- **Pages** = Information pages