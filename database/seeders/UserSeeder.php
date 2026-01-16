<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@trackgo.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create Test User
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        // Create some random users
        User::factory(5)->create();
    }
}
