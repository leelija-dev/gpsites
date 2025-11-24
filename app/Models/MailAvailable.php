<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class MailAvailable extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'mail_available';
    protected $fillable = [
        'user_id',
        'order_id',
        'total_mail',
        'available_mail',
        'deleted_at',
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation: MailAvailable belongs to Order
     */
    public function PlanOrder()
    {
        return $this->belongsTo(PlanOrder::class,'order_id');
    }
}
