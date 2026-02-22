# How to Add Gallery Images

## Step-by-Step Guide

### Method 1: Through Admin Panel (Recommended)

1. **Login to Admin Panel**
   - Go to: `http://your-domain.com/admin/login`
   - Enter your admin credentials

2. **Navigate to Gallery Management**
   - In the admin sidebar, look for "Gallery" menu item
   - Or go directly to: `http://your-domain.com/admin/gallery`

3. **Click "Add New Image" Button**
   - You'll see a green button at the top right
   - This will take you to the gallery creation form

4. **Fill in the Form**
   - **Title** (Required): Enter a descriptive title for the image
   - **Description** (Optional): Add a brief description
   - **Image** (Required): Click "Choose File" and select your image
     - Recommended size: 1200x900px
     - Aspect ratio: 4:3
     - Max file size: 2MB
     - Formats: JPG, PNG, GIF, WebP
   - **Category** (Optional): Select a category to organize images
   - **Display Order**: Enter a number (lower numbers appear first)
   - **Active**: Check this box to make the image visible on the frontend

5. **Click "Add to Gallery"**
   - The image will be uploaded to `public/uploads/gallery/`
   - You'll be redirected to the gallery list

### Method 2: Direct File Upload (Advanced)

If you want to upload images directly via FTP/File Manager:

1. **Upload Image Files**
   - Upload your images to: `public/uploads/gallery/`
   - Use descriptive filenames

2. **Add Database Entry**
   - Go to admin panel: `http://your-domain.com/admin/gallery/create`
   - Fill in the form
   - For the image field, enter the path: `uploads/gallery/your-image.jpg`

## Viewing Gallery Images

### Frontend Gallery Page
- URL: `http://your-domain.com/gallery`
- Shows all active gallery images in a grid layout
- Includes lightbox for full-size viewing
- Filter by category option

### Admin Gallery Management
- URL: `http://your-domain.com/admin/gallery`
- View all gallery images (active and inactive)
- Edit or delete existing images
- See image thumbnails, titles, categories, and status

## Editing Gallery Images

1. Go to: `http://your-domain.com/admin/gallery`
2. Find the image you want to edit
3. Click the edit icon (pencil) button
4. Update the fields you want to change
5. To replace the image, upload a new file (optional)
6. Click "Save Changes"

## Deleting Gallery Images

1. Go to: `http://your-domain.com/admin/gallery`
2. Find the image you want to delete
3. Click the delete icon (trash) button
4. Confirm the deletion
5. The image file will be deleted from the server

## Image Requirements

### Recommended Specifications
- **Dimensions**: 1200x900px
- **Aspect Ratio**: 4:3 (landscape)
- **File Size**: Maximum 2MB
- **Format**: JPG, PNG, GIF, or WebP
- **Quality**: High quality for best display

### Tips for Best Results
- Use high-resolution images for clarity
- Optimize images before upload to reduce file size
- Maintain consistent aspect ratio across all images
- Use descriptive titles for better organization
- Add categories to group related images

## Organizing with Categories

### Assigning Categories
1. When creating/editing a gallery image
2. Select a category from the dropdown
3. Categories help filter images on the frontend
4. Users can click category filters to view specific image groups

### Creating New Categories
- Categories are managed in: `http://your-domain.com/admin/categories`
- Create categories first, then assign them to gallery images

## Display Order

- Lower numbers appear first (0 = highest priority)
- Example order:
  - Order 0: Appears first
  - Order 1: Appears second
  - Order 10: Appears later
- Images with the same order are sorted by creation date (newest first)

## Troubleshooting

### Image Not Uploading
- Check file size (must be under 2MB)
- Verify file format (JPG, PNG, GIF, WebP only)
- Ensure `public/uploads/gallery/` folder exists and is writable
- Check server upload limits in php.ini

### Image Not Showing on Frontend
- Make sure "Active" checkbox is checked
- Verify the image file exists in `public/uploads/gallery/`
- Clear browser cache
- Check if the image path is correct

### Permission Issues
- Folder permissions: `public/uploads/gallery/` should be writable (755 or 775)
- File permissions: Uploaded images should be readable (644)

## Quick Access Links

### Admin Panel
- Gallery List: `/admin/gallery`
- Add New Image: `/admin/gallery/create`
- Edit Image: `/admin/gallery/{id}/edit`

### Frontend
- Gallery Page: `/gallery`
- Gallery with Category Filter: `/gallery?category=category-slug`

## File Structure

```
public/
└── uploads/
    └── gallery/
        ├── 1234567890_image1.jpg
        ├── 1234567891_image2.png
        └── 1234567892_image3.jpg
```

Images are automatically prefixed with a timestamp to prevent naming conflicts.

## Need Help?

If you encounter any issues:
1. Check the Laravel log file: `storage/logs/laravel.log`
2. Verify folder permissions
3. Ensure the database migration has been run
4. Check that the gallery routes are properly configured
