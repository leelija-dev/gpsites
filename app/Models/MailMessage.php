<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailMessage extends Model
{
    protected $fillable = [
        'user_mail_history_id', 'direction', 'from_email', 'from_name',
        'to_emails', 'cc_emails', 'bcc_emails', 'forwarded_to', 'forwarded_cc',
        'subject', 'body_html', 'body_text', 'message_id', 'in_reply_to', 'references',
        'status', 'error', 'sent_at',
    ];

    protected $casts = [
        'to_emails' => 'array', 'cc_emails' => 'array', 'bcc_emails' => 'array',
        'forwarded_to' => 'array', 'forwarded_cc' => 'array', 'sent_at' => 'datetime',
    ];

    public function thread()
    {
        return $this->belongsTo(UserMailHistory::class, 'user_mail_history_id');
    }
}
