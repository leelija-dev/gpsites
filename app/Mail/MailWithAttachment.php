<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailables\Address;
class MailWithAttachment extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $messageBody;
    public $attachment;
    public $replyToList;
    public $fromAddress;

    public function __construct($subject, $messageBody, $attachment = [], $replyToList = [], $fromAddress = null)
    {
        $this->subject = $subject;
        $this->messageBody = $messageBody;
        $this->attachment = $attachment; // Array of stored file paths (relative to storage/app/public)
        $this->replyToList = $replyToList;
        $this->fromAddress = $fromAddress;
        $this->withSymfonyMessage(function ($message) {
            $message->getHeaders()->addTextHeader('X-Blogpub-Relay', '1');
        });
    }

    public function envelope(): Envelope
    {
        // Use custom FROM address if provided (for reply token), otherwise use default
        $fromAddress = $this->fromAddress
            ? new Address($this->fromAddress, config('app.name'))
            : new Address(config('mail.from.address'), config('mail.from.name'));

        $replyToAddresses = collect($this->replyToList)
            ->map(fn ($r) => new Address($r['email'], $r['name'] ?? ''))
            ->all();

        return new Envelope(
            from: $fromAddress,
            replyTo: $replyToAddresses,
            subject: $this->subject
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.generic', // Your Blade template
            with: ['messageBody' => $this->messageBody]
        );
    }

   public function attachments(): array
{
    $files = [];
    
    foreach ($this->attachment as $filePath) {
        if (is_string($filePath) && file_exists(public_path($filePath))) {
            $absolutePath = public_path($filePath);
            $fileName = basename($filePath);
            $files[] = Attachment::fromPath($absolutePath)->as($fileName);
        }
    }

    return $files;
}


}
