<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\Category::all();
        
        $products = [
            [
                'title' => 'iPhone 15 Pro',
                'price' => 999.99,
                'category' => 'Smartphone',
                'image' => 'https://images.unsplash.com/photo-1696446701796-da61225697cc?q=80&w=2070&auto=format&fit=crop'
            ],
            [
                'title' => 'MacBook Air M2',
                'price' => 1199.00,
                'category' => 'Laptops',
                'image' => 'https://images.unsplash.com/photo-1611186871348-b1ec696e52c9?q=80&w=2070&auto=format&fit=crop'
            ],
            [
                'title' => 'Nike Air Max',
                'price' => 150.00,
                'category' => 'Fashion',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=2070&auto=format&fit=crop'
            ],
            [
                'title' => 'Lego Star Wars',
                'price' => 59.99,
                'category' => 'Toys',
                'image' => 'https://images.unsplash.com/photo-1585366119957-e9730b6d0f60?q=80&w=2071&auto=format&fit=crop'
            ],
            [
                'title' => 'Bose Headphones',
                'price' => 299.00,
                'category' => 'Smartphone',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=2070&auto=format&fit=crop'
            ],
        ];

        foreach ($products as $p) {
            $cat = $categories->where('name', $p['category'])->first();
            \App\Models\ProductPage::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($p['title'])],
                [
                    'title' => $p['title'],
                    'price' => $p['price'],
                    'stock' => rand(10, 50),
                    'hero_image' => $p['image'],
                    'category_id' => $cat ? $cat->id : null,
                    'is_published' => true,
                    'content' => []
                ]
            );
        }
    }
}
