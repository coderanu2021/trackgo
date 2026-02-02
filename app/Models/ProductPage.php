<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'hero_image',
        'thumbnail',
        'gallery',
        'is_published',
        'category_id',
        'price',
        'discount',
        'stock',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_enquiry',
    ];

    protected $casts = [
        'content' => 'array',
        'gallery' => 'array',
        'is_published' => 'boolean',
        'is_enquiry' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_page_categories');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_page_id');
    }
}
