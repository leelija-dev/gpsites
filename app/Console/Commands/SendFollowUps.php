<?php

namespace App\Console\Commands;

use App\Mail\MailWithAttachment;
use App\Models\PlanOrder;
use App\Models\User;
use App\Models\UserMailHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Sends a short follow-up in the same email thread when a site owner has not
 * replied to an offer, order or outreach mail. See config/followups.php.
 */
class SendFollowUps extends Command
{
    protected $signature = 'mail:send-followups {--dry-run : List what would be sent without sending}';
    protected $description = 'Send automatic follow-ups to site owners who have not replied';

    public function handle(): int
    {
        if (!config('followups.enabled')) {
            $this->info('Follow-ups are switched off (GPSITES_FOLLOWUPS_ENABLED=false).');
            return 0;
        }

        $days = (array) config('followups.days', []);
        if (!$days) {
            $this->info('No follow-up steps configured.');
            return 0;
        }

        $siteInbox = (string) config('mail.site_inbox');
        if (!str_contains($siteInbox, '@')) {
            $this->error('mail.site_inbox is empty, so follow-ups cannot keep the reply thread.');
            return 1;
        }

        $dry = (bool) $this->option('dry-run');
        $sent = $stopped = 0;

        $threads = UserMailHistory::query()
            ->where('status', true)
            ->whereNotNull('reply_token')
            ->whereNotNull('blog_email')
            ->whereIn('mail_type', (array) config('followups.types', []))
            ->whereNull('followups_stopped_at')
            ->where('followups_sent', '<', count($days))
            ->orderBy('id')
            ->limit(max(1, (int) config('followups.per_run', 200)))
            ->with('messages')
            ->get();

        foreach ($threads as $thread) {
            // 1) Someone replied: stop for good.
            if ($thread->messages->whereIn('direction', UserMailHistory::REPLY_DIRECTIONS)->isNotEmpty()) {
                $dry ?: $thread->stopFollowups('replied');
                $stopped++;
                continue;
            }

            // 2) Too old.
            if ($thread->created_at && $thread->created_at->lt(now()->subDays((int) config('followups.max_age_days', 30)))) {
                $dry ?: $thread->stopFollowups('too_old');
                $stopped++;
                continue;
            }

            // 3) Not due yet.
            $due = $thread->nextFollowupAt();
            if (!$due || $due->isFuture()) {
                continue;
            }

            // 4) Customer must still have an active plan.
            $user = User::find($thread->user_id);
            if (!$user || !$this->hasActivePlan($user->id)) {
                $dry ?: $thread->stopFollowups('plan_expired');
                $stopped++;
                continue;
            }

            $step = (int) $thread->followups_sent + 1;
            $this->line("Thread {$thread->id} ({$thread->mail_type}) -> {$thread->blog_email}: follow-up {$step}/" . count($days));

            if ($dry) {
                $sent++;
                continue;
            }

            if ($this->sendFollowUp($thread, $user, $step, count($days), $siteInbox)) {
                $sent++;
            }
        }

        $this->info("Follow-ups sent: {$sent}. Conversations stopped: {$stopped}." . ($dry ? ' (dry run)' : ''));
        return 0;
    }

    private function hasActivePlan(int $userId): bool
    {
        return PlanOrder::where('user_id', $userId)
            ->where('status', 'completed')
            ->where('expire_at', '>', now())
            ->exists();
    }

    private function sendFollowUp(UserMailHistory $thread, User $user, int $step, int $total, string $siteInbox): bool
    {
        [$local, $domain] = explode('@', $siteInbox);
        $replyAddress = "{$local}+{$thread->reply_token}@{$domain}";

        $outbound = $thread->messages->whereIn('direction', UserMailHistory::OUTBOUND_DIRECTIONS);
        $original = $thread->messages->firstWhere('direction', 'initial');
        $previous = $outbound->whereNotNull('message_id')->last();
        $refs = $thread->messages->whereNotNull('message_id')->pluck('message_id')->map(fn ($id) => "<{$id}>")->implode(' ');

        $host    = parse_url((string) $thread->site_url, PHP_URL_HOST) ?: $thread->site_url;
        $subject = Str::startsWith(strtolower((string) $thread->subject), 're:') ? $thread->subject : 'Re: ' . $thread->subject;
        $isLast  = $step >= $total;

        $note  = $this->followUpText($thread->mail_type, (string) $host, $isLast, (string) $user->name);
        $quote = $original ? $this->quote($original->body_html, $original->sent_at ?? $original->created_at, (string) $user->name) : '';
        $email = $note . $quote;

        // Same people get a copy as with the original mail (the customer and the admin).
        $bcc = collect($original->bcc_emails ?? [$user->email, config('mail.admin_email')])
            ->filter()->map(fn ($e) => strtolower($e))->unique()
            ->reject(fn ($e) => $e === strtolower($thread->blog_email))
            ->values()->all();

        try {
            $mailable = new MailWithAttachment($subject, $email, [], [['email' => $replyAddress, 'name' => config('app.name')]], $replyAddress);
            $mailable->withSymfonyMessage(function ($m) use ($previous, $refs) {
                if ($previous && $previous->message_id) {
                    $m->getHeaders()->addTextHeader('In-Reply-To', "<{$previous->message_id}>");
                }
                if ($refs !== '') {
                    $m->getHeaders()->addTextHeader('References', $refs);
                }
                $m->getHeaders()->addTextHeader('X-GPSites-Followup', '1');
            });

            $sentMessage = Mail::to($thread->blog_email)->bcc($bcc)->send($mailable);

            $thread->messages()->create([
                'direction'   => 'follow_up',
                'from_email'  => $replyAddress,
                'from_name'   => config('app.name'),
                'to_emails'   => [$thread->blog_email],
                'bcc_emails'  => $bcc,
                'subject'     => $subject,
                'body_html'   => $note, // the portal shows the follow-up only, not the quoted original
                'body_text'   => trim(strip_tags($note)),
                'message_id'  => $sentMessage ? trim((string) $sentMessage->getMessageId(), '<> ') : null,
                'in_reply_to' => $previous->message_id ?? null,
                'references'  => $refs,
                'status'      => 'sent',
                'sent_at'     => now(),
            ]);

            $thread->forceFill([
                'followups_sent'   => $step,
                'last_followup_at' => now(),
            ])->save();

            if ($isLast) {
                $thread->stopFollowups('completed');
            }
            return true;
        } catch (\Throwable $e) {
            // Leave the thread as it is; the next run tries again.
            $this->error("  -> failed: " . $e->getMessage());
            Log::error('Follow-up mail failed: ' . $e->getMessage(), ['thread' => $thread->id]);
            return false;
        }
    }

    private function followUpText(?string $type, string $host, bool $isLast, string $name): string
    {
        $host = e($host);

        $lines = match ($type) {
            'offer' => $isLast
                ? ["Hi,", "Checking in one last time about my guest post offer for {$host}. If it isn't a fit right now, that's completely fine. A quick yes or no would help me plan.", "If you'd prefer a different price or topic, just reply with your guidelines."]
                : ["Hi,", "Just following up on my guest post offer for {$host} below, in case it got buried.", "Are you still accepting guest posts? If the price or topic needs adjusting, reply with your guidelines and I'll work with them."],
            'order' => $isLast
                ? ["Hi,", "Following up once more on my order for {$host} below. Could you let me know whether you're able to publish it?", "If anything else is needed from my side, just reply here."]
                : ["Hi,", "Following up on my order for {$host} below. Could you confirm whether you can publish it and roughly when?", "If you need anything else from me, just reply to this email."],
            default => $isLast
                ? ["Hi,", "One last follow-up on my email below about {$host}. If now isn't a good time, no problem at all. A short reply either way would be appreciated."]
                : ["Hi,", "Just following up on my email below about {$host}, in case it got missed.", "I'd be glad to hear your thoughts whenever you have a moment."],
        };

        $html = '';
        foreach ($lines as $line) {
            $html .= '<p style="margin:0 0 14px;">' . $line . '</p>';
        }

        return '<div style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;color:#1f2937;">'
            . $html
            . '<p style="margin:0;">Thanks,<br>' . e($name) . '</p></div>';
    }

    private function quote(?string $html, $when, string $name): string
    {
        if (!$html) {
            return '';
        }
        $date = $when ? $when->format('D, j M Y') : '';

        return '<div style="margin-top:22px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#6b7280;">On '
            . e($date) . ', ' . e($name) . ' wrote:</div>'
            . '<blockquote style="margin:8px 0 0;padding-left:12px;border-left:3px solid #e5e7eb;">' . $html . '</blockquote>';
    }
}
