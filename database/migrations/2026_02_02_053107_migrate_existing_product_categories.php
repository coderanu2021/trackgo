<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing single category relationships to multiple categories
        $products = DB::table('product_pages')
            ->whereNotNull('category_id')
            ->get();

        foreach ($products as $product) {
            // Check if relationship already exists
            $exists = DB::table('product_page_categories')
                ->where('product_page_id', $product->id)
                ->where('category_id', $product->category_id)
                ->exists();

            if (!$exists) {
                DB::table('product_page_categories')->insert([
                    'product_page_id' => $product->id,
                    'category_id' => $product->category_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove all multiple category relationships
        DB::table('product_page_categories')->truncate();
    }
};