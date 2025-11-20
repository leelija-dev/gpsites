<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanOrder extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'transaction_id',
        'paypal_order_id',
        'amount',
        'currency',
        'status',
        'billing_info',
        'payment_details',
        'paid_at',
    ];

    protected $casts = [
        'billing_info' => 'array',
        'payment_details' => 'array',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the user that owns the order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan for this order
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}