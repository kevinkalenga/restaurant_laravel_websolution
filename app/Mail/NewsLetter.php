<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsLetter extends Mailable
{
    use Queueable, SerializesModels;

    public $mailSubject;
    public $mailMessage;

    public function __construct($mailSubject, $mailMessage)
    {
        $this->mailSubject = $mailSubject;
        $this->mailMessage = $mailMessage;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.newsletter',
            with: [
                'title' => $this->mailSubject,
                'mailContent' => $this->mailMessage,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}