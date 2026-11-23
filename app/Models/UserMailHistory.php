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
        'status',
        'description',
        'reply_token', 
        'blog_email',
         'blog_id',
         'mail_type',
        'followups_sent',
        'last_followup_at',
        'followups_stopped_at',
        'followups_stop_reason',
    ];

    protected $casts = [
        'last_followup_at'     => 'datetime',
        'followups_stopped_at' => 'datetime',
    ];

    public function messages()
{
    return $this->hasMany(MailMessage::class, 'user_mail_history_id')->orderBy('created_at');
}

    /** Directions that mean someone answered: follow-ups stop. */
    public const REPLY_DIRECTIONS = ['blog_reply', 'user_reply'];

    /** Outgoing mails from GPSites to the site owner. */
    public const OUTBOUND_DIRECTIONS = ['initial', 'follow_up'];

    /** Can this conversation get follow-ups at all? (type, sent, has a thread address) */
    public function followupsApply(): bool
    {
        return (bool) $this->status
            && $this->reply_token
            && $this->blog_email
            && in_array($this->mail_type, (array) config('followups.types', []), true);
    }

    public function followupsActive(): bool
    {
        return config('followups.enabled')
            && $this->followupsApply()
            && $this->followups_stopped_at === null
            && (int) $this->followups_sent < count((array) config('followups.days', []));
    }

    /** When the next follow-up is due, or null when none will be sent. */
    public function nextFollowupAt(): ?\Illuminate\Support\Carbon
    {
        if (!$this->followupsActive()) {
            return null;
        }
        $days = (array) config('followups.days', []);
        $wait = (int) ($days[(int) $this->followups_sent] ?? 0);
        $last = $this->last_followup_at ?: $this->created_at;

        return $last ? $last->copy()->addDays($wait) : null;
    }

    public function stopFollowups(string $reason): void
    {
        if ($this->followups_stopped_at === null) {
            $this->forceFill(['followups_stopped_at' => now(), 'followups_stop_reason' => $reason])->save();
        }
    }

    /** Short sentence for the conversation page. */
    public function followupStatusText(): ?string
    {
        if (!$this->followupsApply()) {
            return null;
        }
        if ($next = $this->nextFollowupAt()) {
            return 'Automatic follow-ups are on. If the site owner has not replied, the next follow-up goes out around '
                . $next->format('d M Y') . '.';
        }
        return match ($this->followups_stop_reason) {
            'replied'        => 'Automatic follow-ups stopped because the conversation got a reply.',
            'user_stopped'   => 'You stopped automatic follow-ups for this conversation.',
            'plan_expired'   => 'Automatic follow-ups stopped because your plan has expired.',
            'completed'      => 'All automatic follow-ups for this conversation have been sent.',
            'too_old'        => 'Automatic follow-ups ended for this conversation.',
            'before_feature' => null,
            default          => (int) $this->followups_sent > 0 ? 'All automatic follow-ups for this conversation have been sent.' : null,
        };
    }
}
