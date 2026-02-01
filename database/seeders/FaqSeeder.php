<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // GPS Tracking FAQs
            [
                'question' => 'How accurate are your GPS tracking devices?',
                'answer' => 'Our GPS trackers provide accuracy within 2-5 meters under optimal conditions. In urban environments or areas with interference, accuracy may vary slightly but generally remains within 10 meters. Our Pro models feature enhanced GPS and cellular triangulation for maximum accuracy.',
                'category' => 'GPS Tracking',
                'sort_order' => 1,
            ],
            [
                'question' => 'Do I need to pay a monthly subscription fee?',
                'answer' => 'Yes, (if you purchased on a monthly basis) otherwise yearly package is more suitable sometimes. Our devices require a data plan to transmit location information. We offer flexible subscription plans starting at ₹899/month with discounts for annual payment. Each plan includes different features like real-time tracking, geofencing, and historical data, depending on your needs.',
                'category' => 'GPS Tracking',
                'sort_order' => 2,
            ],
            [
                'question' => 'How long do the batteries last?',
                'answer' => 'Battery life varies by model. The EtrackGo Stealth lasts up to 6 days on a single charge, and the EtrackGo Power lasts about 10 days. These estimates are based on standard usage with 5-minute location updates.',
                'category' => 'GPS Tracking',
                'sort_order' => 3,
            ],
            [
                'question' => 'Are there any hidden fees?',
                'answer' => 'No hidden fees. The device price includes the hardware, and the subscription plan you choose covers all tracking services. International roaming may incur additional charges depending on your selected plan. Within India, no Extra Charge.',
                'category' => 'GPS Tracking',
                'sort_order' => 4,
            ],
            [
                'question' => 'How easy is it to install the GPS tracker?',
                'answer' => 'Our trackers are designed for easy installation. The magnetic models can be attached to any metal surface. The hardwired options come with detailed instructions and typically take 15-30 minutes to install. We also offer installation services through our partner network for an additional fee.',
                'category' => 'GPS Tracking',
                'sort_order' => 5,
            ],
            [
                'question' => 'Do the GPS trackers work internationally?',
                'answer' => 'Yes, our devices work in over 150 countries worldwide. Global coverage is available on our Premium and Business subscription plans. Standard plans provide coverage in North America only.',
                'category' => 'GPS Tracking',
                'sort_order' => 6,
            ],
            [
                'question' => 'What is the process for activation?',
                'answer' => 'Activation request can be sent at URL: [activation URL]. Activation is typically completed within 2 hours of receiving your request.',
                'category' => 'GPS Tracking',
                'sort_order' => 7,
            ],
            
            // General FAQs
            [
                'question' => 'What is TrackGo?',
                'answer' => 'TrackGo is a premium e-commerce and project management platform designed for creative professionals and modern businesses.',
                'category' => 'General',
                'sort_order' => 8,
            ],
            [
                'question' => 'How secure is my data?',
                'answer' => 'We use bank-grade encryption and the latest security protocols (Pulse Protocol) to ensure your data stays private and secure at all times.',
                'category' => 'Security',
                'sort_order' => 9,
            ],
            [
                'question' => 'Can I cancel my subscription?',
                'answer' => 'Yes, you can cancel your subscription at any time from your account settings. Your benefits will continue until the end of the billing cycle.',
                'category' => 'Billing',
                'sort_order' => 10,
            ],
            [
                'question' => 'Do you offer a free trial?',
                'answer' => 'We offer a 14-day free trial for our Professional plan, allowing you to explore all our advanced features without any commitment.',
                'category' => 'General',
                'sort_order' => 11,
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
