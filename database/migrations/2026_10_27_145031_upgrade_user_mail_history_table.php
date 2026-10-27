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
        Schema::table('user_mail_history', function (Blueprint $table) {
            if (!Schema::hasColumn('user_mail_history', 'status')) {
                $table->boolean('status')->default(false);
            }
            if (!Schema::hasColumn('user_mail_history', 'description')) {
                $table->text('description')->nullable();
            }
            $table->string('reply_token', 32)->nullable()->unique();
            $table->string('blog_email')->nullable();
            $table->unsignedBigInteger('blog_id')->nullable();
            $table->longText('message')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_mail_history', function (Blueprint $table) {
            $table->deropColumn('reply_token');
            $table->dropColumn('blog_email');
            $table->dropColumn('blog_id');
            
        });
    }
};
