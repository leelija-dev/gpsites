<?php

namespace App\Models;
use Carbon\Carbon;
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
        'duration',
        'currency',
        'status',
        'billing_info',
        'payment_details',
        'paid_at',
        'expire_at',
    ];

    protected $casts = [
        'billing_info' => 'array',
        'payment_details' => 'array',
        'paid_at' => 'datetime',
        'expire_at' => 'datetime',
    ];

    /**
     * Get the user that owns the order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the plan for this order
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class,'plan_id');
    }
    public function mailAvailable()
{
    return $this->hasOne(MailAvailable::class, 'order_id');
}
protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            // If expire_at is modified
            if ($model->isDirty('expire_at')) {

                $original = $model->getOriginal('expire_at');

                // Ensure original value exists
                if ($original) {
                    // Keep time from old datetime
                    $oldTime = Carbon::parse($original)->format('H:i:s');

                    // New date coming from DatePicker
                    $newDate = Carbon::parse($model->expire_at)->format('Y-m-d');

                    // Merge new date + old time
                    $model->expire_at = $newDate . ' ' . $oldTime;
                }
            }
        });
    }

}