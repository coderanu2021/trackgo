<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Image Upload Configuration
    |--------------------------------------------------------------------------
    |
    | Define image sizes, restrictions, and upload paths for all image types
    |
    */

    'upload_path' => 'public/uploads/', // Base upload path (no storage)
    
    'max_file_size' => 5120, // Maximum file size in KB (5MB)
    
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
    
    'sizes' => [
        'product' => [
            'hero_image' => [
                'width' => 1200,
                'height' => 900,
                'ratio' => '4:3',
                'max_size' => 2048, // 2MB
                'description' => 'Product main image (1200x900px, 4:3 ratio, max 2MB)'
            ],
        ],
        
        'category' => [
            'image' => [
                'width' => 400,
                'height' => 400,
                'ratio' => '1:1',
                'max_size' => 512, // 512KB
                'description' => 'Category icon (400x400px, 1:1 ratio, max 512KB)'
            ],
            'banner' => [
                'width' => 1920,
                'height' => 400,
                'ratio' => '16:3.5',
                'max_size' => 2048, // 2MB
                'description' => 'Category banner (1920x400px, 16:3.5 ratio, max 2MB) - Root categories only'
            ],
        ],
        
        'banner' => [
            'image' => [
                'width' => 1920,
                'height' => 600,
                'ratio' => '16:5',
                'max_size' => 3072, // 3MB
                'description' => 'Home banner (1920x600px, 16:5 ratio, max 3MB)'
            ],
        ],
        
        'brand' => [
            'logo' => [
                'width' => 300,
                'height' => 150,
                'ratio' => '2:1',
                'max_size' => 512, // 512KB
                'description' => 'Brand logo (300x150px, 2:1 ratio, max 512KB)'
            ],
        ],
        
        'blog' => [
            'featured_image' => [
                'width' => 1200,
                'height' => 630,
                'ratio' => '1.91:1',
                'max_size' => 2048, // 2MB
                'description' => 'Blog featured image (1200x630px, 1.91:1 ratio, max 2MB)'
            ],
        ],
        
        'settings' => [
            'site_logo' => [
                'width' => 300,
                'height' => 100,
                'ratio' => '3:1',
                'max_size' => 512, // 512KB
                'description' => 'Site logo (300x100px, 3:1 ratio, max 512KB)'
            ],
            'site_favicon' => [
                'width' => 64,
                'height' => 64,
                'ratio' => '1:1',
                'max_size' => 128, // 128KB
                'description' => 'Site favicon (64x64px, 1:1 ratio, max 128KB)'
            ],
            'promo_banner' => [
                'width' => 600,
                'height' => 800,
                'ratio' => '3:4',
                'max_size' => 1024, // 1MB
                'description' => 'Promotional banner (600x800px, 3:4 ratio, max 1MB)'
            ],
        ],
        
        'gallery' => [
            'image' => [
                'width' => 1200,
                'height' => 900,
                'ratio' => '4:3',
                'max_size' => 2048, // 2MB
                'description' => 'Gallery image (1200x900px, 4:3 ratio, max 2MB)'
            ],
        ],
    ],
];
