<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gallery_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Update galleries table to use gallery_category_id instead of category_id
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->foreignId('gallery_category_id')->nullable()->constrained('gallery_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['gallery_category_id']);
            $table->dropColumn('gallery_category_id');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
        });
        
        Schema::dropIfExists('gallery_categories');
    }
};
