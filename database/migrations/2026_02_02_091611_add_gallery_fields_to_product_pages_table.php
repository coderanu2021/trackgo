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
        Schema::table('product_pages', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->after('hero_image');
            $table->text('gallery')->nullable()->after('thumbnail');
            $table->decimal('discount', 15, 2)->default(0)->after('price');
            $table->boolean('is_enquiry')->default(false)->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_pages', function (Blueprint $table) {
            $table->dropColumn(['thumbnail', 'gallery', 'discount', 'is_enquiry']);
        });
    }
};