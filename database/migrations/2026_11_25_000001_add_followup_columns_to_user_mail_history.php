<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_mail_history', function (Blueprint $table) {
            if (!Schema::hasColumn('user_mail_history', 'followups_sent')) {
                $table->unsignedTinyInteger('followups_sent')->default(0);
            }
            if (!Schema::hasColumn('user_mail_history', 'last_followup_at')) {
                $table->timestamp('last_followup_at')->nullable();
            }
            if (!Schema::hasColumn('user_mail_history', 'followups_stopped_at')) {
                $table->timestamp('followups_stopped_at')->nullable();
            }
            if (!Schema::hasColumn('user_mail_history', 'followups_stop_reason')) {
                $table->string('followups_stop_reason', 30)->nullable();
            }
        });

        // Conversations sent before this feature existed never get automatic follow-ups.
        DB::table('user_mail_history')
            ->whereNull('followups_stopped_at')
            ->update(['followups_stopped_at' => now(), 'followups_stop_reason' => 'before_feature']);
    }

    public function down(): void
    {
        Schema::table('user_mail_history', function (Blueprint $table) {
            $table->dropColumn(['followups_sent', 'last_followup_at', 'followups_stopped_at', 'followups_stop_reason']);
        });
    }
};
