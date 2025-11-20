<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class MailWithAttachment extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $messageBody;
    public $attachment;

    public function __construct($subject, $messageBody, $attachment = [])
    {
        $this->subject = $subject;
        $this->messageBody = $messageBody;
        $this->attachment = $attachment; // Array of stored file paths (relative to storage/app/public)
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->subject);
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
