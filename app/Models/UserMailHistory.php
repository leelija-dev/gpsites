<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMailHistory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'user_mail_history';

    protected $fillable = [
        'user_id',
        'site_url',
        'subject',
        'message',
        'file',
        
    ];
}
