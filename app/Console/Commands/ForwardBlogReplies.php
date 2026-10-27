<?php

namespace App\Console\Commands;

use App\Models\MailMessage;
use App\Models\User;
use App\Models\UserMailHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Webklex\IMAP\Facades\Client;

class ForwardBlogReplies extends Command
{
    protected $signature = 'mail:forward-replies';
    protected $description = 'Store replies and relay them between blog owner and user, cc admin';

    public function handle()
    {
        $siteInbox = strtolower((string) config('mail.site_inbox'));
        $adminMail = strtolower((string) config('mail.admin_email'));

        if ($siteInbox === '' || !str_contains($siteInbox, '@')) {
            $this->error('mail.site_inbox is empty. Add MAIL_SITE_INBOX to .env and site_inbox to config/mail.php, then php artisan config:clear');
            return 1;
        }

        try {
            $client = Client::account('default');
            $client->connect();
            $inbox = $client->getFolder('INBOX');

            // since() = last 3 days. Duplicates are prevented by the unique message_id.
            $messages = $inbox->query()->since(now()->subDays(3))->get();
        } catch (\Throwable $e) {
            // e.g. a one-off Gmail "NO System Error": just try again next run
            $this->error('IMAP error: ' . $e->getMessage());
            Log::error('IMAP read failed: ' . $e->getMessage());
            return 1;
        }

        $this->info('Messages found: ' . $messages->count());

        foreach ($messages as $message) {
            $from = $message->getFrom()[0] ?? null;
            $this->line('MAIL from=' . ($from->mail ?? '?')
                . ' | to=' . implode(',', $this->emails($message->getTo()))
                . ' | subject=' . $message->getSubject());

            try {
                $this->process($message, $siteInbox, $adminMail);
            } catch (\Throwable $e) {
                $this->error('  -> ERROR: ' . $e->getMessage());
                Log::error('Reply relay failed: ' . $e->getMessage(), [
                    'from' => $from->mail ?? null,
                    'to' => $this->emails($message->getTo()),
                    'subject' => $message->getSubject(),
                ]);
            }
        }

        return 0;
    }

    private function emails($attr): array
    {
        $out = [];
        foreach ($attr ?? [] as $a) {
            $out[] = strtolower($a->mail);
        }
        return $out;
    }

    private function process($message, string $siteInbox, string $adminMail): void
    {
        $from = $message->getFrom()[0] ?? null;
        if (!$from) { $this->line('  -> skip: no sender'); return; }
        $fromEmail = strtolower($from->mail);

        // loop guards
        if ($fromEmail === $siteInbox || $fromEmail === $adminMail
            || str_contains($fromEmail, 'mailer-daemon') || str_contains($fromEmail, 'no-reply')) {
            $this->line("  -> skip: own/system sender ($fromEmail)");
            return;
        }

        $toList = $this->emails($message->getTo());
        $ccList = $this->emails($message->getCc());

        // thread token from the To or CC address: inbox+token@domain
        $token = null;
        $allRecipients = array_merge($toList, $ccList);
        foreach ($allRecipients as $t) {
            if (preg_match('/\+([a-z0-9]{12})@/', $t, $m)) { $token = $m[1]; break; }
        }
        if (!$token) {
            $this->line('  -> skip: no +token in To/CC (addresses: ' . implode(',', $allRecipients) . ')');
            return;
        }

        $history = UserMailHistory::where('reply_token', $token)->first();
        $user    = $history ? User::find($history->user_id) : null;
        if (!$history || !$user) {
            $this->line("  -> skip: no thread/user for token $token");
            Log::warning('No thread/user found for reply token', ['token' => $token, 'from' => $fromEmail]);
            return;
        }

        $messageId = trim((string) $message->getMessageId(), '<> ');
        if ($messageId === '') {
            $messageId = 'gen-' . md5($fromEmail . $message->getDate() . $message->getSubject());
        }

        // skip only if already forwarded (failed ones are retried)
        $record = MailMessage::where('message_id', $messageId)->first();
        if ($record && $record->status === 'forwarded') { $this->line('  -> already forwarded'); return; }

        // direction: who wrote it, who gets it
        $isUser    = $fromEmail === strtolower($user->email);
        $direction = $isUser ? 'user_reply' : 'blog_reply';
        $to        = $isUser ? $history->blog_email : $user->email;
        $label     = $isUser ? $user->name . ' (via ' . config('app.name') . ')'
                             : ($from->personal ?: $from->mail);

        // body: keep the full text, forward a trimmed and escaped version
        $full  = trim($message->getTextBody() ?: strip_tags($message->getHTMLBody()));
        $clean = trim(preg_split('/\R(On .+ wrote:|-{2,}\s*Original Message|From:\s)/i', $full)[0]);
        $bodyHtml = nl2br(e($clean !== '' ? $clean : $full));

        $subject = $message->getSubject() ?: 'Re: ' . $history->subject;
        $cc      = ($adminMail && $adminMail !== $fromEmail) ? [$adminMail] : []; // admin CC on every reply (except if admin is sender)

        // 1) STORE first, so nothing is lost if forwarding fails
        $record = $record ?: $history->messages()->create([
            'direction'   => $direction,
            'from_email'  => $fromEmail,
            'from_name'   => $from->personal,
            'to_emails'   => $toList,
            'cc_emails'   => $ccList,
            'subject'     => $subject,
            'body_html'   => $bodyHtml,
            'body_text'   => $full,
            'message_id'  => $messageId,
            'in_reply_to' => Str::limit(trim((string) $message->getInReplyTo(), '<> '), 250, ''),
            'references'  => (string) $message->getReferences(),
            'status'      => 'received',
        ]);
        $this->line("  -> stored as $direction (id {$record->id})");

        // 2) FORWARD (Reply-To stays the token address, so the next reply returns to the site)
        [$local, $domain] = explode('@', $siteInbox);
        $replyTo = "{$local}+{$token}@{$domain}";

        try {
            $html = view('emails.reply-forward', [
                'blogName' => $label,
                'siteUrl'  => $history->site_url,
                'body'     => $bodyHtml,
            ])->render();

            Mail::html($html, function ($m) use ($to, $subject, $cc, $replyTo) {
                $m->to($to)->subject($subject)->replyTo($replyTo, config('app.name'));
                if ($cc) $m->cc($cc);
            });

            $record->update([
                'forwarded_to' => [$to],
                'forwarded_cc' => $cc,
                'status'       => 'forwarded',
                'error'        => null,
                'sent_at'      => now(),
            ]);
            $this->info("  -> FORWARDED to $to" . ($cc ? ' (cc ' . implode(',', $cc) . ')' : ''));
        } catch (\Throwable $e) {
            $record->update(['status' => 'failed', 'error' => Str::limit($e->getMessage(), 1000)]);
            $this->error('  -> forward failed: ' . $e->getMessage());
            Log::error('Reply forward failed: ' . $e->getMessage());
        }
    }
}