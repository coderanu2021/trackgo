<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use Illuminate\Support\Str;

class GeneralPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'title' => 'Ultra-Slim Gaming Laptop',
                'price' => 1299.00,
                'discount' => 100.00,
                'stock' => 15,
                'thumbnail' => '/uploads/products/laptop.png',
                'gallery' => [
                    'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=800',
                    'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800'
                ],
                'content' => [
                    ['type' => 'text', 'data' => ['content' => '<h2>High-Performance Gaming</h2><p>Experience gaming like never before with the latest RTX graphics and a stunning 240Hz display.</p>']]
                ]
            ],
            [
                'title' => 'Premium Mechanical Keyboard',
                'price' => 189.00,
                'discount' => 0.00,
                'stock' => 50,
                'thumbnail' => '/uploads/products/keyboard.png',
                'gallery' => [
                    'https://images.unsplash.com/photo-1511467687858-23d96c32e4ae?w=800',
                    'https://images.unsplash.com/photo-1595225476474-87563907a212?w=800'
                ],
                'content' => [
                    ['type' => 'text', 'data' => ['content' => '<h2>Ultimate Typing Experience</h2><p>Custom-tuned switches and premium build quality for professionals and gamers alike.</p>']]
                ]
            ],
            [
                'title' => 'Wireless Noise Cancelling Headphones',
                'price' => 349.00,
                'discount' => 50.00,
                'stock' => 25,
                'thumbnail' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800',
                'gallery' => [
                    'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800',
                    'https://images.unsplash.com/photo-1491926626787-62db157af940?w=800'
                ],
                'content' => [
                    ['type' => 'text', 'data' => ['content' => '<h2>Crystal Clear Audio</h2><p>Industry-leading noise cancellation technology to keep you immersed in your music.</p>']]
                ]
            ]
        ];

        foreach ($products as $product) {
            Page::updateOrCreate(
                ['slug' => Str::slug($product['title'])],
                [
                    'title' => $product['title'],
                    'price' => $product['price'],
                    'discount' => $product['discount'],
                    'stock' => $product['stock'],
                    'thumbnail' => $product['thumbnail'],
                    'gallery' => $product['gallery'],
                    'content' => $product['content'],
                    'is_active' => true,
                    'meta_title' => $product['title'],
                    'meta_description' => 'Premium product: ' . $product['title'],
                ]
            );
        }
    }
}
