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
        Schema::create('plan_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('plan_id');
            $table->string('transaction_id')->nullable()->unique(); // PayPal transaction ID - made nullable
            $table->string('paypal_order_id')->nullable(); // PayPal order ID
            $table->decimal('amount', 10, 2); // Payment amount
            $table->string('currency', 10)->default('USD'); // Currency
            $table->string('status')->default('pending'); // pending, completed, failed, cancelled
            $table->json('billing_info')->nullable(); // Store billing information as JSON
            $table->json('payment_details')->nullable(); // Store payment response details
            $table->timestamp('paid_at')->nullable(); // When payment was completed
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_orders');
    }
};