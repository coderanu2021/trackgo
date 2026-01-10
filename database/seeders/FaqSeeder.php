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
            [
                'question' => 'What is TrackGo?',
                'answer' => 'TrackGo is a premium e-commerce and project management platform designed for creative professionals and modern businesses.',
                'category' => 'General',
                'sort_order' => 1,
            ],
            [
                'question' => 'How secure is my data?',
                'answer' => 'We use bank-grade encryption and the latest security protocols (Pulse Protocol) to ensure your data stays private and secure at all times.',
                'category' => 'Security',
                'sort_order' => 2,
            ],
            [
                'question' => 'Can I cancel my subscription?',
                'answer' => 'Yes, you can cancel your subscription at any time from your account settings. Your benefits will continue until the end of the billing cycle.',
                'category' => 'Billing',
                'sort_order' => 3,
            ],
            [
                'question' => 'Do you offer a free trial?',
                'answer' => 'We offer a 14-day free trial for our Professional plan, allowing you to explore all our advanced features without any commitment.',
                'category' => 'General',
                'sort_order' => 4,
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
