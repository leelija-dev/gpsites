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
        Schema::create('mail_available', function (Blueprint $table) {
            $table->id();
           $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->integer('total_mail')->default(0);
            $table->integer('available_mail')->default(0);
            $table->timestamps();
             $table->softDeletes();

            
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
             $table->foreign('user_id', 'fk_mail_available_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('plan_orders')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_available');
    }
};
