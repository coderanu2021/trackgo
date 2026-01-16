<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElectronicsProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing products
        \App\Models\Page::truncate();

        $categories = [
            'Smartphone' => ['icon' => 'fas fa-mobile-alt', 'slug' => 'smartphone'],
            'Laptops' => ['icon' => 'fas fa-laptop', 'slug' => 'laptops'],
            'Audio' => ['icon' => 'fas fa-headphones', 'slug' => 'audio'],
            'Cameras' => ['icon' => 'fas fa-camera', 'slug' => 'cameras'],
            'Wearables' => ['icon' => 'fas fa-clock', 'slug' => 'wearables'],
            'Gaming' => ['icon' => 'fas fa-gamepad', 'slug' => 'gaming'],
            'Industrial' => ['icon' => 'fas fa-microchip', 'slug' => 'industrial'],
        ];

        $catModels = [];
        foreach ($categories as $name => $data) {
            $catModels[$name] = \App\Models\Category::updateOrCreate(
                ['slug' => $data['slug']],
                ['name' => $name, 'icon' => $data['icon'], 'is_active' => true]
            );
        }

        $products = [
            // Smartphones
            [
                'title' => 'iPhone 15 Pro Max',
                'category' => 'Smartphone',
                'price' => 1199.00,
                'discount' => 100.00,
                'stock' => 50,
                'thumbnail' => 'https://images.unsplash.com/photo-1695048133142-1a20484d25fa?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Samsung Galaxy S24 Ultra',
                'category' => 'Smartphone',
                'price' => 1299.00,
                'discount' => 150.00,
                'stock' => 45,
                'thumbnail' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Google Pixel 8 Pro',
                'category' => 'Smartphone',
                'price' => 999.00,
                'discount' => 50.00,
                'stock' => 30,
                'thumbnail' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&q=80&w=800',
            ],

            // Laptops
            [
                'title' => 'MacBook Pro 16-inch M3 Max',
                'category' => 'Laptops',
                'price' => 3499.00,
                'discount' => 200.00,
                'stock' => 15,
                'thumbnail' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Dell XPS 15 9530',
                'category' => 'Laptops',
                'price' => 2199.00,
                'discount' => 300.00,
                'stock' => 20,
                'thumbnail' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'ASUS ROG Zephyrus G14',
                'category' => 'Laptops',
                'price' => 1599.00,
                'discount' => 100.00,
                'stock' => 25,
                'thumbnail' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?auto=format&fit=crop&q=80&w=800',
            ],

            // Audio
            [
                'title' => 'Sony WH-1000XM5 Headphones',
                'category' => 'Audio',
                'price' => 399.00,
                'discount' => 50.00,
                'stock' => 100,
                'thumbnail' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Bose QuietComfort Ultra',
                'category' => 'Audio',
                'price' => 429.00,
                'discount' => 0.00,
                'stock' => 80,
                'thumbnail' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'AirPods Pro (2nd Gen)',
                'category' => 'Audio',
                'price' => 249.00,
                'discount' => 20.00,
                'stock' => 150,
                'thumbnail' => 'https://images.unsplash.com/photo-1588156979435-379b9d802b0a?auto=format&fit=crop&q=80&w=800',
            ],

            // Cameras
            [
                'title' => 'Sony Alpha a7 IV',
                'category' => 'Cameras',
                'price' => 2499.00,
                'discount' => 100.00,
                'stock' => 12,
                'thumbnail' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Canon EOS R6 Mark II',
                'category' => 'Cameras',
                'price' => 2299.00,
                'discount' => 0.00,
                'stock' => 10,
                'thumbnail' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Fujifilm X-T5',
                'category' => 'Cameras',
                'price' => 1699.00,
                'discount' => 50.00,
                'stock' => 18,
                'thumbnail' => 'https://images.unsplash.com/photo-1516724562728-afc824a36e84?auto=format&fit=crop&q=80&w=800',
            ],

            // Wearables
            [
                'title' => 'Apple Watch Ultra 2',
                'category' => 'Wearables',
                'price' => 799.00,
                'discount' => 50.00,
                'stock' => 40,
                'thumbnail' => 'https://images.unsplash.com/photo-1434493907317-a46b5bc78344?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Samsung Galaxy Watch 6 Pro',
                'category' => 'Wearables',
                'price' => 449.00,
                'discount' => 50.00,
                'stock' => 60,
                'thumbnail' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Garmin Fenix 7X Sapphire',
                'category' => 'Wearables',
                'price' => 899.00,
                'discount' => 100.00,
                'stock' => 25,
                'thumbnail' => 'https://images.unsplash.com/photo-1544117518-30dd5ff7a986?auto=format&fit=crop&q=80&w=800',
            ],

            // Gaming
            [
                'title' => 'PlayStation 5 Console',
                'category' => 'Gaming',
                'price' => 499.00,
                'discount' => 0.00,
                'stock' => 100,
                'thumbnail' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Xbox Series X',
                'category' => 'Gaming',
                'price' => 499.00,
                'discount' => 20.00,
                'stock' => 90,
                'thumbnail' => 'https://images.unsplash.com/photo-1605901309584-818e25960a8f?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Nintendo Switch OLED',
                'category' => 'Gaming',
                'price' => 349.00,
                'discount' => 0.00,
                'stock' => 120,
                'thumbnail' => 'https://images.unsplash.com/photo-1578303372217-b7473345a552?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Razer Blade 18 Gaming Laptop',
                'category' => 'Gaming',
                'price' => 2899.00,
                'discount' => 200.00,
                'stock' => 8,
                'thumbnail' => 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Stream Deck MK.2',
                'category' => 'Gaming',
                'price' => 149.00,
                'discount' => 10.00,
                'stock' => 50,
                'thumbnail' => 'https://images.unsplash.com/photo-1625842268584-8f3bf9ff16a0?auto=format&fit=crop&q=80&w=800',
            ],
        ];

        foreach ($products as $p) {
            \App\Models\Page::create([
                'category_id' => $catModels[$p['category']]->id,
                'title' => $p['title'],
                'slug' => \Illuminate\Support\Str::slug($p['title']),
                'price' => $p['price'],
                'discount' => $p['discount'],
                'stock' => $p['stock'],
                'thumbnail' => $p['thumbnail'],
                'is_active' => true,
                'content' => [
                    ['type' => 'text', 'content' => 'High-performance electronics piece from our premium collection.', 'style' => ['padding_top' => 2, 'padding_bottom' => 2]],
                    ['type' => 'features', 'content' => ['points' => ['Premium Build Quality', 'Top Tier Performance', '1 Year Warranty']], 'style' => []],
                ],
                'meta_title' => $p['title'] . ' | TechGO Store',
                'meta_description' => 'Buy ' . $p['title'] . ' at the best price on TechGO.',
                'meta_keywords' => 'electronics, ' . strtolower($p['category']) . ', ' . strtolower($p['title']),
            ]);
        }
    }
}
