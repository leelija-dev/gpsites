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
}
