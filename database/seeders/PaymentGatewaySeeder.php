<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateways = [
            [
                'name' => 'Razorpay',
                'slug' => 'razorpay',
                'display_name' => 'Razorpay',
                'description' => 'Pay securely with Credit/Debit Cards, Net Banking, UPI & Wallets',
                'config' => [
                    'key_id' => 'rzp_test_your_key_id',
                    'key_secret' => 'your_key_secret',
                    'webhook_secret' => 'your_webhook_secret'
                ],
                'is_active' => true,
                'is_test_mode' => true,
                'supported_currencies' => ['INR'],
                'min_amount' => 1.00,
                'max_amount' => 1000000.00,
                'sort_order' => 1
            ],
            [
                'name' => 'Stripe',
                'slug' => 'stripe',
                'display_name' => 'Stripe',
                'description' => 'Pay with Credit/Debit Cards via Stripe',
                'config' => [
                    'publishable_key' => 'pk_test_your_publishable_key',
                    'secret_key' => 'sk_test_your_secret_key',
                    'webhook_secret' => 'whsec_your_webhook_secret'
                ],
                'is_active' => false,
                'is_test_mode' => true,
                'supported_currencies' => ['USD', 'EUR', 'GBP', 'INR'],
                'min_amount' => 0.50,
                'max_amount' => 999999.99,
                'sort_order' => 2
            ],
            [
                'name' => 'PayPal',
                'slug' => 'paypal',
                'display_name' => 'PayPal',
                'description' => 'Pay with your PayPal account or Credit/Debit Card',
                'config' => [
                    'client_id' => 'your_paypal_client_id',
                    'client_secret' => 'your_paypal_client_secret',
                    'mode' => 'sandbox' // sandbox or live
                ],
                'is_active' => false,
                'is_test_mode' => true,
                'supported_currencies' => ['USD', 'EUR', 'GBP', 'CAD', 'AUD'],
                'min_amount' => 1.00,
                'max_amount' => 10000.00,
                'sort_order' => 3
            ],
            [
                'name' => 'Manual Payment',
                'slug' => 'manual',
                'display_name' => 'Bank Transfer / Cash on Delivery',
                'description' => 'Pay via bank transfer or cash on delivery',
                'config' => [
                    'instructions' => 'Please transfer the amount to our bank account and share the transaction details.',
                    'bank_details' => [
                        'account_name' => 'Your Company Name',
                        'account_number' => '1234567890',
                        'bank_name' => 'Your Bank Name',
                        'ifsc_code' => 'BANK0001234'
                    ]
                ],
                'is_active' => true,
                'is_test_mode' => false,
                'supported_currencies' => ['INR', 'USD', 'EUR'],
                'min_amount' => 1.00,
                'max_amount' => null,
                'sort_order' => 4
            ]
        ];

        foreach ($gateways as $gateway) {
            \App\Models\PaymentGateway::updateOrCreate(
                ['slug' => $gateway['slug']],
                $gateway
            );
        }
    }
}
