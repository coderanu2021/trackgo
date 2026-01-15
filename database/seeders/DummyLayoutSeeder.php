<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\Page;
use App\Models\ProductPage;
use App\Models\User;
use Illuminate\Support\Str;

class DummyLayoutSeeder extends Seeder
{
    public function run()
    {
        $user = User::first() ?? User::factory()->create();

        // ---------------------------------------------------------
        // 1. COMPLEX LANDING PAGE (ProductPage)
        // ---------------------------------------------------------
        $landingContent = [
            [
                'type' => 'hero_stats',
                '_id' => 'hero-' . uniqid(),
                'data' => [
                    'title' => 'Revolutionizing Enterprise Logistics',
                    'description' => 'TrackGo provides state-of-the-art surveillance and tracking solutions for global supply chains.',
                    'image' => 'https://images.unsplash.com/photo-1586528116311-ad86d7c7184a?q=80&w=2000',
                    'stats' => [
                        ['value' => '50k+', 'label' => 'Active Shipments'],
                        ['value' => '99.9%', 'label' => 'Uptime SLA'],
                        ['value' => '120+', 'label' => 'Countries Covered']
                    ]
                ]
            ],
            [
                'type' => 'features',
                '_id' => 'feat-' . uniqid(),
                'data' => [
                    'items' => [
                        ['title' => 'Real-time Tracking', 'description' => 'Monitor your assets 24/7 with GPS accuracy.'],
                        ['title' => 'AI Analytics', 'description' => 'Predictive maintenance and route optimization.'],
                        ['title' => 'Secure Cloud', 'description' => 'Enterprise-grade encryption for all your logistics data.']
                    ]
                ]
            ],
            [
                'type' => 'split_content',
                '_id' => 'split-' . uniqid(),
                'data' => [
                    'position' => 'left',
                    'title' => 'Advanced Visual Surveillance',
                    'description' => 'Our integrated CCTV systems use AI to detect anomalies in warehouse operations automatically.',
                    'image' => 'https://images.unsplash.com/photo-1557597774-9d2739f85a94?q=80&w=1000',
                    'stats' => [
                        ['value' => '2ms', 'label' => 'Latency'],
                        ['value' => '4K', 'label' => 'Resolution']
                    ]
                ]
            ],
            [
                'type' => 'timeline',
                '_id' => 'time-' . uniqid(),
                'data' => [
                    'events' => [
                        ['year' => '2022', 'title' => 'Global Expansion', 'badge' => 'Phase 1'],
                        ['year' => '2023', 'title' => 'AI Core Integration', 'badge' => 'V2.0'],
                        ['year' => '2024', 'title' => 'Carbon Neutral Logistics', 'badge' => 'Green Goal']
                    ]
                ]
            ]
        ];

        ProductPage::updateOrCreate(
            ['slug' => 'trackgo-landing'],
            [
                'title' => 'TrackGo Enterprise Solutions',
                'hero_image' => 'https://images.unsplash.com/photo-1494412574743-01947f2060ed?q=80&w=2000',
                'content' => $landingContent,
                'is_published' => true,
                'meta_title' => 'TrackGo | Leading Logistics Technology',
                'meta_description' => 'Explore professional logistics and surveillance solutions with TrackGo.'
            ]
        );

        // ---------------------------------------------------------
        // 2. COMPLEX BLOG POST (Blog)
        // ---------------------------------------------------------
        $blogContent = [
            [
                'type' => 'text',
                '_id' => 'text-' . uniqid(),
                'data' => ['content' => '<h2 style="font-size: 2rem;">The Future of Smart Warehousing</h2><p>As we move into 2026, the integration of IoT and robotics is transforming how warehouses operate. No longer just storage spaces, they are becoming "intelligent hubs" that predict 수요 before it even happens.</p>']
            ],
            [
                'type' => 'image',
                '_id' => 'img-' . uniqid(),
                'data' => ['url' => 'https://images.unsplash.com/photo-1580674684081-7617fbf3d745?q=80&w=1200', 'caption' => 'A fully automated robotic warehouse in action.']
            ],
            [
                'type' => 'features',
                '_id' => 'feat-blog-' . uniqid(),
                'data' => [
                    'items' => [
                        ['title' => 'Automation', 'description' => 'AGVs reducing human error by 80%.'],
                        ['title' => 'Sustainability', 'description' => 'Solar-powered facilities reducing carbon footprint.'],
                        ['title' => 'Efficiency', 'description' => '24/7 operations without downtime.']
                    ]
                ],
                'styles' => ['margin_top' => 3, 'border_radius' => 20]
            ]
        ];

        Blog::updateOrCreate(
            ['slug' => 'future-smart-warehousing'],
            [
                'title' => 'The Future of Smart Warehousing in 2026',
                'content' => $blogContent,
                'image' => 'https://images.unsplash.com/photo-1590644365607-1c5a519a9a37?q=80&w=800',
                'is_published' => true,
                'user_id' => $user->id,
                'meta_title' => 'Smart Warehousing Trends 2026',
                'meta_description' => 'Deep dive into the latest technologies shaping modern logistics.'
            ]
        );

        // ---------------------------------------------------------
        // 3. COMPLEX PRODUCT PAGE (Page)
        // ---------------------------------------------------------
        $productContent = [
            [
                'type' => 'columns',
                '_id' => 'col-' . uniqid(),
                'data' => [
                    'columns' => [
                        [
                            'width' => '50%',
                            'blocks' => [
                                [
                                    'type' => 'text',
                                    '_id' => 'p-text-' . uniqid(),
                                    'data' => ['content' => '<h3>Precision Hardware</h3><p>Our TG-X1 sensor is designed for extreme conditions, operating reliably from -40°C to +85°C.</p>']
                                ]
                            ]
                        ],
                        [
                            'width' => '50%',
                            'blocks' => [
                                [
                                    'type' => 'image',
                                    '_id' => 'p-img-' . uniqid(),
                                    'data' => ['url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=600']
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'type' => 'tabs',
                '_id' => 'tabs-' . uniqid(),
                'data' => [
                    'tabs' => [
                        ['title' => 'Specifications', 'content' => '<p>Battery: 5 years<br>Connectivity: 5G/LTE<br>Weight: 150g</p>'],
                        ['title' => 'Installation', 'content' => '<p>Magnetic mount or screw-in bracket. Sets up in under 5 minutes.</p>'],
                        ['title' => 'Support', 'content' => '<p>24/7 technical assistance and 2-year full replacement warranty.</p>']
                    ]
                ]
            ]
        ];

        Page::updateOrCreate(
            ['slug' => 'trackgo-tgx1-sensor'],
            [
                'title' => 'TrackGo TG-X1 Industrial Sensor',
                'price' => 499.00,
                'discount' => 50.00,
                'stock' => 100,
                'thumbnail' => 'https://images.unsplash.com/photo-1558346490-a72e53ae2d4f?q=80&w=1000',
                'gallery' => [
                    'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800',
                    'https://images.unsplash.com/photo-1558346490-a72e53ae2d4f?w=800'
                ],
                'content' => $productContent,
                'is_active' => true,
                'meta_title' => 'TG-X1 Industrial Sensor | TrackGo',
                'meta_description' => 'The ultimate industrial tracking sensor for harsh environments.'
            ]
        );
    }
}
