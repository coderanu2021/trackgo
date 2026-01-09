<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'icon', 'is_active'];

    public function productPages()
    {
        return $this->hasMany(ProductPage::class);
    }
}
