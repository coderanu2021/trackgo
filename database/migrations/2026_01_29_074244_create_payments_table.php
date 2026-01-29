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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique(); // Our internal payment ID
            $table->string('gateway_payment_id')->nullable(); // Gateway's payment ID
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('gateway'); // razorpay, stripe, paypal, etc.
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('INR');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded'])->default('pending');
            $table->json('gateway_response')->nullable(); // Store gateway response
            $table->json('metadata')->nullable(); // Additional data
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'gateway']);
            $table->index(['order_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
