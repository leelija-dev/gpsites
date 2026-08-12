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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug');
            $table->string('category')->nullable();
            $table->text('tags')->nullable();
            $table->string('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('feature_image_alt')->nullable();
            $table->string('feature_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('schema')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
