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
        Schema::create('blog_order_mail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();          // who ordered
            $table->unsignedBigInteger('blog_id')->index();
            $table->string('website_name')->nullable();
            $table->string('site_url')->nullable();
            $table->string('blog_email')->nullable();
            $table->string('price_type', 60);                         // e.g. general_guest_post_price
            $table->string('price_label', 100);                       // e.g. General Guest Post
            $table->decimal('price', 10, 2);
            $table->longText('content');                              // link or article (sanitized HTML)
            $table->unsignedBigInteger('user_mail_history_id')->nullable(); // the mail thread
            $table->string('status', 20)->default('pending');         // pending | mailed | failed
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_order_mail');
    }
};
