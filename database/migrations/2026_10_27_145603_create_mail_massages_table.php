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
        Schema::create('mail_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_mail_history_id')->index();
            $table->string('direction', 20);            // initial | blog_reply | user_reply
            $table->string('from_email');
            $table->string('from_name')->nullable();
            $table->json('to_emails')->nullable();      // as received
            $table->json('cc_emails')->nullable();
            $table->json('bcc_emails')->nullable();     // initial mail only
            $table->json('forwarded_to')->nullable();   // what the site relayed
            $table->json('forwarded_cc')->nullable();   // admin copy
            $table->string('subject')->nullable();
            $table->longText('body_html')->nullable();
            $table->longText('body_text')->nullable();
            $table->string('message_id', 255)->nullable()->unique();
            $table->string('in_reply_to', 255)->nullable();
            $table->text('references')->nullable();
            $table->string('status', 20)->default('pending'); // sent|received|forwarded|failed
            $table->text('error')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->foreign('user_mail_history_id')
                  ->references('id')->on('user_mail_history')
                  ->cascadeOnDelete();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_messages');
    }
};
