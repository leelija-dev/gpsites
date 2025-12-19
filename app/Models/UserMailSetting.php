<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMailSetting extends Model
{
    use SoftDeletes;
    protected $table = 'user_mail_setting';
    protected $fillable = [
        'user_id',
        'name',
        'smtp_host',
        'smtp_port',
        'smtp_encryption',
        'email',
        'password',
        'is_primary'
    ];
}
