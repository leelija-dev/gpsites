<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogOrderMail extends Model
{
    protected $table = 'blog_order_mail';
    protected $fillable = [
        'user_id',
        'blog_id',
        'website_name',
        'site_url',
        'blog_email',
        'price_type',
        'price_label',
        'price',
        'content',
        'user_mail_history_id',
        'status',
        'error',
    ];
    protected $casts = ['price' => 'decimal:2'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(UserMailHistory::class, 'user_mail_history_id');
    }

}
