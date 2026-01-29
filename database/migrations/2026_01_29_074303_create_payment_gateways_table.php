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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Razorpay, Stripe, PayPal, etc.
            $table->string('slug')->unique(); // razorpay, stripe, paypal
            $table->string('display_name'); // Display name for frontend
            $table->text('description')->nullable();
            $table->json('config'); // Store API keys and configuration
            $table->boolean('is_active')->default(false);
            $table->boolean('is_test_mode')->default(true);
            $table->json('supported_currencies')->nullable(); // ['INR', 'USD', 'EUR']
            $table->decimal('min_amount', 15, 2)->default(1.00);
            $table->decimal('max_amount', 15, 2)->nullable();
            $table->string('logo')->nullable(); // Gateway logo
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
