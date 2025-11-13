<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlansFeature extends Model
{
    use SoftDeletes; // Enables soft delete support

    /**
     * The table associated with the model.
     */
    protected $table = 'plans_feature';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'plan_id',
        'feature',
        'is_active',
    ];

    /**
     * Define relationship with Plan model.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
