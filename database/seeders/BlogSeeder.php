<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Top 10 Modern Design Trends in 2026',
                'content' => 'The world of design is constantly evolving. In 2026, we are seeing a shift towards more immersive and personalized experiences. From augmented reality interfaces to minimalist glassmorphism, the trends are exciting. Designers are prioritizing accessibility and sustainability more than ever before. This article explores the top 10 trends that are shaping the future of digital and physical design.',
                'image' => 'https://images.unsplash.com/photo-1541462608141-ad4d05942ad5?auto=format&fit=crop&q=80&w=800',
                'is_published' => true,
                'user_id' => 1,
            ],
            [
                'title' => 'The Future of E-commerce: What to Expect',
                'content' => 'E-commerce has come a long way since its inception. Today, it is not just about buying and selling online; it is about building a community and providing value beyond the product. Artificial intelligence, social commerce, and personalized shopping assistant bots are becoming the norm. Retailers who adapt to these changes will thrive in the competitive landscape of tomorrow.',
                'image' => 'https://images.unsplash.com/photo-1556742044-3c52d6e88c62?auto=format&fit=crop&q=80&w=800',
                'is_published' => true,
                'user_id' => 1,
            ],
            [
                'title' => 'Building a Brand in the Digital Age',
                'content' => 'A brand is no longer just a logo or a catchy slogan. It is the sum of all the experiences a customer has with your company. In the digital age, authenticity is key. Customers want to connect with brands that share their values and tell a compelling story. This post discusses strategy and tactics for building a powerful and lasting brand identity in a crowded digital world.',
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=800',
                'is_published' => true,
                'user_id' => 1,
            ]
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(
                ['slug' => Str::slug($blog['title'])],
                [
                    'title' => $blog['title'],
                    'content' => $blog['content'],
                    'image' => $blog['image'],
                    'is_published' => $blog['is_published'],
                    'user_id' => $blog['user_id'],
                ]
            );
        }
    }
}
