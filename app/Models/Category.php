<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'icon', 'is_active', 'parent_id'];

    public function productPages()
    {
        return $this->hasMany(ProductPage::class);
    }

    public function products()
    {
        return $this->belongsToMany(ProductPage::class, 'product_page_categories');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
