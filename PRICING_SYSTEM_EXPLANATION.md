# Product Pricing System - Complete Guide

## 🎯 How the Pricing System Works

### Your Example: Product originally ₹15,000, now selling for ₹12,500

**Admin Input:**
- **Selling Price**: ₹12,500 (what customer pays)
- **Discount Amount**: ₹2,500 (amount off from original price)

**Customer Sees:**
- ~~₹15,000~~ ₹12,500 (original price in red with strikethrough, current price in theme color)

## 📊 Database Structure

```sql
-- In pages/product_pages table
price DECIMAL(15,2)     -- Selling price (₹12,500)
discount DECIMAL(15,2)  -- Discount amount (₹2,500)
```

## 🖥️ Frontend Display Logic

```php
// Original price (red with strikethrough)
$originalPrice = $product->price + $product->discount; // ₹12,500 + ₹2,500 = ₹15,000

// Current selling price (theme color)
$sellingPrice = $product->price; // ₹12,500
```

## 🎨 Visual Display

### Product Cards & Lists:
```html
<span style="color: #ef4444; text-decoration: line-through;">₹15,000</span>
<span style="color: var(--primary); font-weight: 700;">₹12,500</span>
```

### Discount Badge:
```php
$discountPercentage = round(($discount / ($price + $discount)) * 100); // 17% off
```

## 🔧 Admin Interface Improvements

### Clear Labels:
- **Selling Price (₹)**: Current price customers will pay
- **Discount Amount (₹)**: Amount off from original price (shows strikethrough)

### Live Preview:
- Real-time preview showing exactly how prices will appear to customers
- Updates automatically as you type
- Shows/hides original price based on discount amount

## 📱 Responsive Display

All price displays are fully responsive and work across:
- Desktop product grids
- Mobile product cards
- Product detail pages
- Checkout pages
- Admin forms

## 🌍 Indian Formatting

All prices use Indian number formatting:
- ₹1,23,456.78 (not ₹123,456.78)
- Implemented via `formatIndianPrice()` helper function

## ✅ Examples

### Example 1: Product with Discount
- **Admin enters**: Selling Price = ₹12,500, Discount = ₹2,500
- **Customer sees**: ~~₹15,000~~ ₹12,500
- **Discount badge**: -17%

### Example 2: Product without Discount
- **Admin enters**: Selling Price = ₹8,999, Discount = ₹0
- **Customer sees**: ₹8,999 (no strikethrough price)
- **Discount badge**: None

### Example 3: High Discount Product
- **Admin enters**: Selling Price = ₹1,999, Discount = ₹3,000
- **Customer sees**: ~~₹4,999~~ ₹1,999
- **Discount badge**: -60%

## 🎯 Key Benefits

1. **Clear for Admins**: Intuitive form labels with live preview
2. **Attractive for Customers**: Red strikethrough creates urgency
3. **Flexible System**: Works with any discount amount
4. **Consistent Display**: Same logic across all pages
5. **Mobile Optimized**: Responsive design for all devices
6. **Indian Standards**: Proper currency formatting

The system is now perfectly set up for your pricing needs!