<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Category;
use Illuminate\Support\Str;

class GpsProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create GPS category if it doesn't exist
        $gpsCategory = Category::firstOrCreate(
            ['slug' => 'gps-devices'],
            [
                'name' => 'GPS Devices',
                'is_active' => true,
                'icon' => 'fas fa-map-marked-alt'
            ]
        );

        $rkGpsProducts = [
            [
                'title' => 'ETG03 Vehicle Tracker',
                'price' => 4999.00,
                'discount' => 500.00,
                'stock' => 25,
                'thumbnail' => 'https://images.unsplash.com/photo-1551808525-51a94da548ce?w=800&h=800&fit=crop',
                'description' => 'A compact, reliable GPS tracker with real-time updates, geo-fencing, and smart analytics. Easy to install and ideal for all types of vehicles.',
                'features' => [
                    'Real-time GPS tracking',
                    'Geo-fencing alerts',
                    'Smart analytics dashboard',
                    'Easy installation',
                    'Compatible with all vehicle types',
                    'Mobile app support',
                    'Historical route playback'
                ]
            ],
            [
                'title' => 'ETG06 Vehicle Tracker',
                'price' => 5999.00,
                'discount' => 600.00,
                'stock' => 30,
                'thumbnail' => 'https://images.unsplash.com/photo-1606041008023-472dfb5e530f?w=800&h=800&fit=crop',
                'description' => 'Smart tracking made easy. The ETG06 model offers improved GPS chip performance, quick installation, and precise reporting. Track vehicle history, set alerts, and reduce operational costs.',
                'features' => [
                    'Improved GPS chip performance',
                    'Quick installation process',
                    'Precise location reporting',
                    'Vehicle history tracking',
                    'Custom alert settings',
                    'Cost reduction analytics',
                    'Advanced fleet management'
                ]
            ],
            [
                'title' => 'GPS E-Lock System (JT701)',
                'price' => 12999.00,
                'discount' => 1000.00,
                'stock' => 15,
                'thumbnail' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=800&fit=crop',
                'description' => 'GPS based e-locking system manufactured by Etrackgo. Extremely useful to safely deliver valuable assets. Ideal for banks, retail malls, and container tracking.',
                'features' => [
                    'Real-time tracking capability',
                    'History and playback functionality',
                    'Geo-fencing with alerts',
                    'Door open/close reports with location and time',
                    'RFID keyless locking/unlocking',
                    'Anti-break and anti-theft protection',
                    'Tamper alert notifications',
                    'Rechargeable battery with low battery alarm',
                    'Vibration resistant design',
                    'Dust and waterproof (IP67)',
                    'Cloud-based security system'
                ]
            ],
            [
                'title' => 'Container GPS Tracker (G300)',
                'price' => 8999.00,
                'discount' => 900.00,
                'stock' => 20,
                'thumbnail' => 'https://images.unsplash.com/photo-1512499617640-c74ae3a79d37?w=800&h=800&fit=crop',
                'description' => 'Specialized GPS tracking device for container monitoring. Cellular-based tracking with specialized software for theft prevention and asset security.',
                'features' => [
                    'Cellular-based tracking technology',
                    'Specialized container monitoring software',
                    'Theft prevention alerts',
                    'Real-time location updates',
                    'Container door status monitoring',
                    'Long battery life',
                    'Weather resistant design'
                ]
            ],
            [
                'title' => 'Advanced Asset Tracker (G400)',
                'price' => 9999.00,
                'discount' => 1200.00,
                'stock' => 18,
                'thumbnail' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=800&h=800&fit=crop',
                'description' => 'Professional grade GPS tracker for high-value asset protection. Features advanced security protocols and comprehensive monitoring capabilities.',
                'features' => [
                    'Professional grade GPS accuracy',
                    'Advanced security protocols',
                    'Comprehensive asset monitoring',
                    'Multi-platform compatibility',
                    'Remote configuration options',
                    'Detailed reporting system',
                    'Emergency alert system'
                ]
            ],
            [
                'title' => 'Personal GPS Tracker Mini',
                'price' => 3999.00,
                'discount' => 400.00,
                'stock' => 40,
                'thumbnail' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&h=800&fit=crop',
                'description' => 'Compact personal GPS tracker perfect for individual safety, child monitoring, and personal asset tracking. Easy to use with mobile app integration.',
                'features' => [
                    'Ultra-compact design',
                    'Personal safety monitoring',
                    'Child tracking capability',
                    'SOS emergency button',
                    'Mobile app integration',
                    'Long battery life',
                    'Real-time location sharing'
                ]
            ],
            [
                'title' => 'Fleet Management GPS System',
                'price' => 15999.00,
                'discount' => 2000.00,
                'stock' => 12,
                'thumbnail' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&h=800&fit=crop',
                'description' => 'Complete fleet management solution with advanced GPS tracking, driver monitoring, and comprehensive analytics for commercial vehicle operations.',
                'features' => [
                    'Multi-vehicle tracking dashboard',
                    'Driver behavior monitoring',
                    'Fuel consumption tracking',
                    'Route optimization',
                    'Maintenance scheduling',
                    'Comprehensive analytics',
                    'Commercial grade reliability'
                ]
            ],
            [
                'title' => 'Wireless GPS Tracker Pro',
                'price' => 6999.00,
                'discount' => 700.00,
                'stock' => 25,
                'thumbnail' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=800&h=800&fit=crop',
                'description' => 'Professional wireless GPS tracking device with cellular connectivity. Ideal for various tracking applications with reliable performance.',
                'features' => [
                    'Wireless connectivity',
                    'Cellular network support',
                    'Professional grade accuracy',
                    'Multiple application support',
                    'Reliable performance',
                    'Easy deployment',
                    'Cost-effective solution'
                ]
            ]
        ];

        foreach ($rkGpsProducts as $productData) {
            $content = [
                [
                    'type' => 'text',
                    'data' => [
                        'content' => '<h2>Product Overview</h2><p>' . $productData['description'] . '</p><p>Manufactured and supplied by RK Enterprises, Sangrur, Punjab - your trusted GPS solutions provider for over 19 years.</p>'
                    ]
                ],
                [
                    'type' => 'text',
                    'data' => [
                        'content' => '<h3>Key Features</h3><ul>' . 
                        implode('', array_map(fn($feature) => '<li>' . $feature . '</li>', $productData['features'])) . 
                        '</ul>'
                    ]
                ],
                [
                    'type' => 'text',
                    'data' => [
                        'content' => '<h3>Technical Support</h3><p>This professional GPS device comes with comprehensive warranty and technical support from RK Enterprises. Perfect for both personal and commercial use with reliable after-sales service.</p><p><strong>Contact:</strong> Aggarwal Complex Basement, Mahavir Chowk, Barnala Road, Near Civil Hospital, Sangrur HO-148001</p>'
                    ]
                ]
            ];

            Page::updateOrCreate(
                ['slug' => Str::slug($productData['title'])],
                [
                    'category_id' => $gpsCategory->id,
                    'title' => $productData['title'],
                    'price' => $productData['price'],
                    'discount' => $productData['discount'],
                    'stock' => $productData['stock'],
                    'thumbnail' => $productData['thumbnail'],
                    'gallery' => [
                        $productData['thumbnail'],
                        'https://images.unsplash.com/photo-1551808525-51a94da548ce?w=800',
                        'https://images.unsplash.com/photo-1606041008023-472dfb5e530f?w=800',
                        'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800'
                    ],
                    'content' => $content,
                    'is_active' => true,
                    'meta_title' => $productData['title'] . ' - RK Enterprises GPS Solutions',
                    'meta_description' => $productData['description'],
                    'meta_keywords' => 'GPS, tracking, RK Enterprises, vehicle tracker, asset tracking, fleet management'
                ]
            );
        }

        $this->command->info('RK Enterprises GPS products seeded successfully!');
    }
}