<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class EnquireProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update 2 random products to be "Enquire Now"
        $products = Page::where('is_active', true)->inRandomOrder()->take(2)->get();
        
        foreach ($products as $product) {
            $product->update(['is_enquiry' => true]);
        }
        
        // Ensure at least one explicit "Enquiry Product" exists if none found
        if ($products->isEmpty()) {
             Page::create([
                'title' => 'Custom Enterprise Solution',
                'slug' => 'custom-enterprise-solution',
                'content' => [['type' => 'text', 'data' => ['content' => 'Contact us for a quote.']]],
                'is_active' => true,
                'is_enquiry' => true,
                'price' => 0,
                'category_id' => 1 // Assuming 1 exists
            ]);
        }
    }
}
