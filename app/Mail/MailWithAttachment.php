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

    public function __construct($subject, $messageBody, $attachment = [], $replyToList = [])
    {
        $this->subject = $subject;
        $this->messageBody = $messageBody;
        $this->attachment = $attachment; // Array of stored file paths (relative to storage/app/public)
        $this->replyToList = $replyToList;
    }

    public function envelope(): Envelope
    {
        $replyToAddresses = collect($this->replyToList)
            ->map(fn ($r) => new Address($r['email'], $r['name'] ?? ''))
            ->all();

        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            replyTo: $replyToAddresses,
            subject: $this->subject,
            using: [
                function ($message) use ($replyToAddresses) {
                    // Force Reply-To header for better client compatibility
                    if (!empty($replyToAddresses)) {
                        foreach ($replyToAddresses as $address) {
                            $message->getHeaders()->addTextHeader('Reply-To', $address->address);
                        }
                    }
                }
            ]
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
