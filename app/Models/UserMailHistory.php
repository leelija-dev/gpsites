<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMailHistory extends Model
{
    protected $table = 'user_mail_history';

    protected $fillable = [
        'user_id',
        'site_url',
        'subject',
        'message',
        'file',
        
    ];
}
