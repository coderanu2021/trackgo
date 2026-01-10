<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Smartphone', 'icon' => 'fas fa-mobile-alt'],
            ['name' => 'Laptops', 'icon' => 'fas fa-laptop'],
            ['name' => 'Fashion', 'icon' => 'fas fa-tshirt'],
            ['name' => 'Toys', 'icon' => 'fas fa-robot'],
            ['name' => 'Automobiles', 'icon' => 'fas fa-car'],
            ['name' => 'Home decoration', 'icon' => 'fas fa-home'],
            ['name' => 'Industrial', 'icon' => 'fas fa-industry'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($cat['name'])],
                ['name' => $cat['name'], 'icon' => $cat['icon'], 'is_active' => true]
            );
        }
    }
}
