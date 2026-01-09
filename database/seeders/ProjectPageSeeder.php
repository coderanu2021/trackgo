<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductPage;

class ProjectPageSeeder extends Seeder
{
    public function run()
    {
        $content = [
            // Hero Stats Block
            [
                'type' => 'hero_stats',
                'data' => [
                    'title' => 'Trusted Partner for Large Scale Government Infrastructure Projects',
                    'description' => 'Unlocking the Potential of Technology for Governance & Public Safety.',
                    'image' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=2940&auto=format&fit=crop', // Voting/Government placeholder
                    'stats' => [
                        ['value' => '3,00,000+', 'label' => 'Cameras Deployed'],
                        ['value' => '100+', 'label' => 'Command Centers'],
                        ['value' => '10 Cr+', 'label' => 'People Impacted'],
                        ['value' => '25+', 'label' => 'States Covered'],
                    ]
                ]
            ],
            // Timeline Block
            [
                'type' => 'timeline',
                'data' => [
                    'events' => [
                        [
                            'year' => '2025',
                            'title' => 'Delhi Assembly Elections',
                            'badge' => '24,000 Cameras'
                        ],
                        [
                            'year' => '2024',
                            'title' => 'Lok Sabha Elections',
                            'badge' => '1,50,000 Cameras'
                        ],
                        [
                            'year' => '2023',
                            'title' => 'G20 Summit Surveillance',
                            'badge' => '5,000 Cameras'
                        ],
                        [
                            'year' => '2022',
                            'title' => 'UP Assembly Elections',
                            'badge' => '1,00,000 Cameras'
                        ]
                    ]
                ]
            ],
            // Split Content 1: Socio-Economic
            [
                'type' => 'split_content',
                'data' => [
                    'position' => 'left',
                    'image' => 'https://images.unsplash.com/photo-1455849318743-b2233052fcff?q=80&w=2938&auto=format&fit=crop', // Family/Socio placeholder
                    'title' => 'Socio-Economic Surveys',
                    'description' => 'Enabling data-driven policy making through comprehensive household surveys and biometric data collection.',
                    'stats' => [
                        ['value' => '10 Cr+', 'label' => 'Citizens Surveyed'],
                        ['value' => '100%', 'label' => 'Digital Data']
                    ]
                ]
            ],
            // Split Content 2: Aadhaar (Reverse)
            [
                'type' => 'split_content',
                'data' => [
                    'position' => 'right',
                    'image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?q=80&w=2940&auto=format&fit=crop', // Tech/Identity placeholder
                    'title' => 'Aadhaar Enrolment',
                    'description' => 'Facilitating the largest digital identity program in the world through secure and efficient enrolment centers.',
                    'stats' => [
                        ['value' => '5 Cr+', 'label' => 'Aadhaar Generated'],
                        ['value' => '500+', 'label' => 'Centers']
                    ]
                ]
            ],
            // Split Content 3: National Population Register
            [
                'type' => 'split_content',
                'data' => [
                    'position' => 'left',
                    'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2940&auto=format&fit=crop', // Census/People placeholder
                    'title' => 'National Population Register',
                    'description' => 'Digitizing the details of usual residents of the country to create a comprehensive identity database.',
                    'stats' => [
                        ['value' => '70 Cr+', 'label' => 'Records Digitized'],
                        ['value' => '15+', 'label' => 'States Covered']
                    ]
                ]
            ],
             // Features Block (Refactored Test)
            [
                'type' => 'features',
                'data' => [
                    'items' => [
                        ['title' => 'Surveillance', 'description' => 'AI-powered CCTV analytical solutions.'],
                        ['title' => 'Biometrics', 'description' => 'Fingerprint and Iris authentication systems.'],
                        ['title' => 'Analytics', 'description' => 'Real-time data processing and reporting.']
                    ]
                ]
            ]

        ];

        ProductPage::updateOrCreate(
            ['slug' => 'projects'],
            [
                'title' => 'Our Projects',
                'hero_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2940&auto=format&fit=crop',
                'content' => $content,
                'is_published' => true
            ]
        );
    }
}
