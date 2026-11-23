<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'duration',
        'mail_available',
        'is_active',
    ];

    public function features()
    {
        return $this->hasMany(\App\Models\PlansFeature::class, 'plan_id', 'id');
    }

    public const BILLING_MONTHLY = 'monthly';
    public const BILLING_YEARLY = 'yearly';

    /** Normalise any input ("yearly", "annual", "year"...) to monthly or yearly. Monthly is the default. */
    public static function normalizeBillingCycle($value): string
    {
        $value = strtolower(trim((string) $value));
        return in_array($value, ['yearly', 'annual', 'annually', 'year'], true)
            ? self::BILLING_YEARLY
            : self::BILLING_MONTHLY;
    }

    /** Yearly discount in percent (config/gpsites.php). */
    public static function yearlyDiscountPercent(): float
    {
        return (float) config('gpsites.yearly_discount_percent', 20);
    }

    /** Free plans (the trial) are never billed yearly. */
    public function supportsYearly(): bool
    {
        return (float) $this->price > 0;
    }

    /** Amount charged for one billing period: monthly = price; yearly = 12 x price minus the discount. */
    public function priceFor(string $cycle): float
    {
        $monthly = (float) $this->price;
        if ($cycle !== self::BILLING_YEARLY || ! $this->supportsYearly()) {
            return round($monthly, 2);
        }
        return round($monthly * 12 * (1 - self::yearlyDiscountPercent() / 100), 2);
    }

    /** Effective monthly price on the chosen cycle (for display: "$158.40 / month, billed yearly"). */
    public function monthlyEquivalentFor(string $cycle): float
    {
        return $cycle === self::BILLING_YEARLY && $this->supportsYearly()
            ? round($this->priceFor($cycle) / 12, 2)
            : round((float) $this->price, 2);
    }

    /** Days of access bought for one billing period. */
    public function durationFor(string $cycle): int
    {
        return $cycle === self::BILLING_YEARLY && $this->supportsYearly()
            ? 365
            : (int) ($this->duration ?: 30);
    }
}
