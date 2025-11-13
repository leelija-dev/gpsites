<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Plan name
            $table->string('slug')->unique(); // For URLs or identifiers
            $table->text('description')->nullable(); // Plan description
            $table->decimal('price', 10, 2); // Price amount
            $table->string('currency', 10)->default('INR'); // Currency code (e.g., USD, INR)
            $table->integer('duration')->default(30); // Duration in days
            $table->integer('mail_available')->default(10);
            $table->boolean('is_active')->default(true); // Status
            $table->softDeletes(); // ✅ Enables soft delete (adds deleted_at column)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
