<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailHistories extends Model
{
    protected $table = 'mail_history';

    protected $fillable = [
        'email',
        'subject',
        'message',
        'status',
        'sent_at',
    ];
}
