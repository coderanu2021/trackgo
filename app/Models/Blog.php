<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'is_published',
        'user_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        $image = $this->image;

        // If it contains storage/, restart the path from there to handle domain changes
        if (str_contains($image, 'storage/')) {
            $path = substr($image, strpos($image, 'storage/'));
            return asset($path);
        }
        
        // If it contains uploads/, restart the path from there to handle domain changes
        if (str_contains($image, 'uploads/')) {
            $path = substr($image, strpos($image, 'uploads/'));
            return asset($path);
        }

        // If it's a relative path, wrap in asset()
        if (!str_starts_with($image, 'http')) {
            return asset($image);
        }

        return $image;
    }
}
