<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Banner::create([
            'title' => "Women's Latest\nFashion Sale",
            'subtitle' => 'Trending Item',
            'image' => 'https://placehold.co/600x400', // Using a placeholder service
            'link' => '#',
            'type' => 'main',
            'is_active' => true,
            'order' => 1
        ]);

        \App\Models\Banner::create([
            'title' => "Summer Collection\nNew Arrivals",
            'subtitle' => 'Hot Deal',
            'image' => 'https://placehold.co/600x400/orange/white',
            'link' => '#',
            'type' => 'main',
            'is_active' => true,
            'order' => 2
        ]);
    }
}
