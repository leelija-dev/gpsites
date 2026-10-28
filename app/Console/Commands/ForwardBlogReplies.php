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

            // since() = last 30 days. Duplicates are prevented by the unique message_id.
            $messages = $inbox->query()->since(now()->subDays(30))->get();
        } catch (\Throwable $e) {
            // e.g. a one-off Gmail "NO System Error": just try again next run
            $this->error('IMAP error: ' . $e->getMessage());
            Log::error('IMAP read failed: ' . $e->getMessage());
            return 1;
        }

        $this->info('Messages found: ' . $messages->count());

        foreach ($messages as $message) {
            $from = $message->getFrom()[0] ?? null;
            $toEmails = $this->emails($message->getTo());

            // If getTo() returns empty, parse raw header for display
            if (empty($toEmails)) {
                $rawTo = $message->getHeader()->get('to');
                if ($rawTo) {
                    $toEmails = $this->parseRawToHeader($rawTo);
                }
            }

            $this->line('MAIL from=' . ($from->mail ?? '?')
                . ' | to=' . implode(',', $toEmails)
                . ' | subject=' . $message->getSubject());

            try {
                $this->process($message, $siteInbox, $adminMail);
            } catch (\Throwable $e) {
                $this->error('  -> ERROR: ' . $e->getMessage());
                Log::error('Reply relay failed: ' . $e->getMessage(), [
                    'from' => $from->mail ?? null,
                    'to' => $toEmails,
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

    private function parseRawToHeader($header): array
    {
        $emails = [];
        // Parse raw header like "Lakshman Pal <lakshman.leelija+token@gmail.com>, Admin <admin@gmail.com>"
        if (preg_match_all('/<([^>]+)>/', $header, $matches)) {
            foreach ($matches[1] as $email) {
                $emails[] = strtolower(trim($email));
            }
        } elseif (preg_match_all('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', $header, $matches)) {
            foreach ($matches[1] as $email) {
                $emails[] = strtolower(trim($email));
            }
        }
        return $emails;
    }

    private function process($message, string $siteInbox, string $adminMail): void
    {
        $from = $message->getFrom()[0] ?? null;
        if (!$from) { $this->line('  -> skip: no sender'); return; }
        $fromEmail = strtolower($from->mail);

        // // loop guards
        // if ($fromEmail === $siteInbox || $fromEmail === $adminMail
        //     || str_contains($fromEmail, 'mailer-daemon') || str_contains($fromEmail, 'no-reply')) {
        //     $this->line("  -> skip: own/system sender ($fromEmail)");
        //     return;
        // }
                // loop guards: skip our own relayed mails (marked by header) and system senders
        $rawHeaders = (string) ($message->getHeader()->raw ?? '');
        if (stripos($rawHeaders, 'X-Blogpub-Relay:') !== false
            || str_contains($fromEmail, 'mailer-daemon') || str_contains($fromEmail, 'no-reply')) {
            $this->line("  -> skip: our own relayed mail or system sender ($fromEmail)");
            return;
        }
        $toList = $this->emails($message->getTo());
        $ccList = $this->emails($message->getCc());

        // If getTo() returns empty, parse raw header
        if (empty($toList)) {
            $rawTo = $message->getHeader()->get('to');
            if ($rawTo) {
                $toList = $this->parseRawToHeader($rawTo);
            }
        }

        // Method 1: thread token from the To or CC address: inbox+token@domain
        $token = null;
        $allRecipients = array_merge($toList, $ccList);
        foreach ($allRecipients as $t) {
            if (preg_match('/\+([a-z0-9]{12})@/', $t, $m)) { $token = $m[1]; break; }
        }

        // Method 2: If no token in To/CC, use In-Reply-To message ID threading
        // $history = null;
        // if (!$token) {
        //     $inReplyTo = trim((string) $message->getInReplyTo(), '<> ');
        //     if ($inReplyTo) {
        //         $previousMessage = MailMessage::where('message_id', $inReplyTo)->first();
        //         if ($previousMessage) {
        //             $history = UserMailHistory::find($previousMessage->user_mail_history_id);
        //             if ($history) {
        //                 $token = $history->reply_token;
        //                 $this->line('  -> found token via In-Reply-To message ID');
        //             }
        //         }
        //     }
        // }
                // Method 2: no token in To/CC, so use In-Reply-To / References message IDs
        $history = null;
        if (!$token) {
            $ids = [];
            $raw = trim((string) $message->getInReplyTo()) . ' ' . trim((string) $message->getReferences());
            foreach (preg_split('/[\s,]+/', $raw) as $id) {
                $id = trim($id, '<> ');
                if ($id !== '') $ids[] = $id;
            }

            if ($ids) {
                $previous = MailMessage::whereIn('message_id', array_unique($ids))->latest('id')->first();
                $history  = $previous ? UserMailHistory::find($previous->user_mail_history_id) : null;
                if ($history) {
                    $token = $history->reply_token;
                    $this->line('  -> found token via References/In-Reply-To');
                }
            }
        }
        if (!$token) {
            $this->line('  -> skip: no +token in To/CC and no matching message ID (addresses: ' . implode(',', $allRecipients) . ')');
            return;
        }

        // If history not found via message ID, find it via token
        if (!$history) {
            $history = UserMailHistory::where('reply_token', $token)->first();
        }

        $user    = $history ? User::find($history->user_id) : null;
        if (!$history || !$user) {
            $this->line("  -> skip: no thread/user for token $token");
            Log::warning('No thread/user found for reply token', ['token' => $token, 'from' => $fromEmail]);
            return;
        }
        if ($fromEmail === $adminMail && $fromEmail !== strtolower($user->email)) {
            $this->line('  -> skip: admin reply (admin is only cc)');
            return;
        }
        $messageId = trim((string) $message->getMessageId(), '<> ');
        if ($messageId === '') {
            $messageId = 'gen-' . md5($fromEmail . $message->getDate() . $message->getSubject());
        }

        // skip only if already forwarded (failed ones are retried)
        $record = MailMessage::where('message_id', $messageId)->first();
        if ($record && $record->status === 'forwarded') { $this->line('  -> already forwarded'); return; }

        // Get the previous message's message_id for threading
        $previousMessageId = null;
        $previousMessage = $history->messages()->where('status', 'forwarded')->latest()->first();
        if ($previousMessage && $previousMessage->message_id) {
            $previousMessageId = $previousMessage->message_id;
        }

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

            // Mail::html($html, function ($m) use ($to, $subject, $cc, $replyTo, $previousMessageId) {
            //     $m->to($to)->subject($subject)->from($replyTo, config('app.name'))->replyTo($replyTo, config('app.name'));
            //     if ($cc) $m->cc($cc);
            //     // Set In-Reply-To for message threading
            //     if ($previousMessageId) {
            //         $m->getHeaders()->addTextHeader('In-Reply-To', "<{$previousMessageId}>");
            //     }
            // });
                        $refs = $history->messages()->whereNotNull('message_id')->pluck('message_id')
                ->map(fn ($i) => "<$i>")->implode(' ');

            Mail::html($html, function ($m) use ($to, $subject, $cc, $replyTo, $previousMessageId, $refs) {
                $m->to($to)->subject($subject)->from($replyTo, config('app.name'))->replyTo($replyTo, config('app.name'));
                $m->getHeaders()->addTextHeader('X-Blogpub-Relay', '1');
                if ($cc) $m->cc($cc);
                if ($previousMessageId) {
                    $m->getHeaders()->addTextHeader('In-Reply-To', "<{$previousMessageId}>");
                }
                if ($refs) {
                    $m->getHeaders()->addTextHeader('References', $refs);
                }
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