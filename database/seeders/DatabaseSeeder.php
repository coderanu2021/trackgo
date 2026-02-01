<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SettingsSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            GpsProductSeeder::class, // RK Enterprises GPS Products
            ProjectPageSeeder::class,
            BlogSeeder::class,
            PlanSeeder::class,
            FaqSeeder::class,
            BannerSeeder::class,
            AboutPageSeeder::class, // Proper about page seeder
            // GeneralPageSeeder::class, // Removed to prevent products going to pages table
            DummyLayoutSeeder::class,
            PaymentGatewaySeeder::class, // Payment gateways
        ]);
    }
}
