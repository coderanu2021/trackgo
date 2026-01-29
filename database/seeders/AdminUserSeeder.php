<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create admin user if not exists
        $adminUser = User::where('email', 'admin@trackgo.com')->first();
        
        if (!$adminUser) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@trackgo.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'login_type' => 'email',
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Admin user created: admin@trackgo.com / admin123');
        } else {
            $this->command->info('Admin user already exists');
        }
    }
}