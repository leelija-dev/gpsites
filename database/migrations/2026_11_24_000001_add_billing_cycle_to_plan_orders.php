<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Records whether an order was billed monthly or yearly.
     * Existing orders default to "monthly", which is how they were billed.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('plan_orders', 'billing_cycle')) {
            Schema::table('plan_orders', function (Blueprint $table) {
                $table->string('billing_cycle', 10)->default('monthly')->after('duration');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('plan_orders', 'billing_cycle')) {
            Schema::table('plan_orders', function (Blueprint $table) {
                $table->dropColumn('billing_cycle');
            });
        }
    }
};
