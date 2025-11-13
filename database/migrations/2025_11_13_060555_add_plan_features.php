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
        Schema::create('plans_feature', function (Blueprint $table) {
            $table->id();

            // Foreign key referencing 'plans' table
            $table->foreignId('plan_id')
                ->constrained('plans') // References 'id' on 'plans' table
                ->onDelete('cascade'); // Deletes features if plan is deleted

            $table->string('feature'); // For URLs or identifiers
            $table->boolean('is_active')->default(true); // Status
            $table->softDeletes(); // Enables soft delete (adds deleted_at column)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans_feature');
    }
};
