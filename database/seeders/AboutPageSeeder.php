<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use Illuminate\Support\Str;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create About Us page
        Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About Us',
                'content' => [
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<h2>About Etrackgo</h2><p>Etrackgo, a brand name of R K Enterprises, has been a leading provider of innovative technology solutions since 2005. Founded by Mr. Rahul Garg, our company has evolved over the years to become a trusted partner for government departments and organizations across India.</p>'
                        ]
                    ],
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<h3>Our Journey</h3><p>Our journey began with the sale and distribution of IT products such as computers, laptops, servers, UPS, and networking products. In 2012, we expanded our offerings by opening exclusive stores for Dell and HP brands. As we continued to grow, we diversified our portfolio to include security cameras in 2016 and vehicle tracking systems in 2018.</p>'
                        ]
                    ],
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<h3>Our Expertise</h3><p>Today, Etrackgo is a one-stop solution for all your technology needs. Our expertise includes:</p><ul><li>Vehicle tracking devices and GPS solutions</li><li>Live streaming solutions for elections, events, and surveillance</li><li>Security cameras and monitoring systems</li><li>IT products and solutions, including computers, laptops, servers, UPS, and networking products</li></ul>'
                        ]
                    ],
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<h3>Our Clients</h3><p>We are proud to have served some of the most prestigious government departments and organizations, including:</p><ul><li>Election Departments of Punjab, Haryana, Uttarakhand, and Bihar</li><li>Transport Departments</li><li>Police Departments</li><li>Education Departments</li><li>Excise Departments</li></ul>'
                        ]
                    ],
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<h3>Our Achievements</h3><p>Our commitment to excellence and customer satisfaction has earned us several notable achievements, including:</p><ul><li>Successful deployment of over 12,000 GPS tracking devices for the Punjab Elections in 2019</li><li>Deployment of over 10,000 GPS tracking devices for the Haryana Elections in 2019</li><li>Successful completion of the Uttarakhand State Election Department project in 2014</li><li>Live streaming of elections in thousands of cameras in single screen for several districts in Haryana</li><li>Live streaming of polling booths in Patiala in 2024</li><li>Deployment of approximately 10,000 GPS tracking devices for the Bihar Elections in 2025</li></ul>'
                        ]
                    ],
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<h3>Why Choose Us</h3><p>At Etrackgo, we pride ourselves on our:</p><ul><li>Strong hardware and software capabilities</li><li>Experienced installation and support team</li><li>Proven track record of delivering high-quality solutions</li><li>Commitment to customer satisfaction and support</li></ul>'
                        ]
                    ],
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<h3>Get in Touch</h3><p>If you\'re looking for a reliable partner for your technology needs, please don\'t hesitate to contact us. We\'re always ready to take on new challenges and deliver innovative solutions that exceed your expectations.</p>'
                        ]
                    ]
                ],
                'is_active' => true,
                'meta_title' => 'About Us - Etrackgo',
                'meta_description' => 'Learn about Etrackgo, a leading provider of GPS tracking solutions and technology services since 2005. Trusted by government departments across India.',
                'meta_keywords' => 'about etrackgo, gps tracking company, technology solutions, government projects, vehicle tracking'
            ]
        );

        // Create Contact page
        Page::updateOrCreate(
            ['slug' => 'contact'],
            [
                'title' => 'Contact Us',
                'content' => [
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<h2>Get in Touch</h2><p>We\'d love to hear from you. Contact us for any inquiries about our GPS tracking solutions and technology services.</p>'
                        ]
                    ],
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<h3>Contact Information</h3><p>Reach out to us through any of the following channels:</p>'
                        ]
                    ]
                ],
                'is_active' => true,
                'meta_title' => 'Contact Us - Etrackgo',
                'meta_description' => 'Contact Etrackgo for GPS tracking solutions and technology services. Get in touch with our expert team.',
                'meta_keywords' => 'contact etrackgo, gps tracking support, technology services contact'
            ]
        );
    }
}