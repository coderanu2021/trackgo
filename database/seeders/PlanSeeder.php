<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'price' => 29.00,
                'cycle' => 'monthly',
                'features' => json_encode(['5 Products', 'Basic Analytics', 'Community Support', '1 Admin User']),
                'is_featured' => false,
            ],
            [
                'name' => 'Professional',
                'price' => 79.00,
                'cycle' => 'monthly',
                'features' => json_encode(['Unlimited Products', 'Advanced Analytics', 'Priority Support', '5 Admin Users', 'API Access']),
                'is_featured' => true,
            ],
            [
                'name' => 'Enterprise',
                'price' => 199.00,
                'cycle' => 'monthly',
                'features' => json_encode(['Custom Solutions', 'Dedicated Server', '24/7 Phone Support', 'Unlimited Admin Users', 'Custom Integrations']),
                'is_featured' => false,
            ]
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
