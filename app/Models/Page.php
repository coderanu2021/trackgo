<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'price',
        'discount',
        'stock',
        'thumbnail',
        'gallery'
    ];

    protected $casts = [
        'content' => 'json',
        'gallery' => 'json',
        'is_active' => 'boolean'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'page_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
