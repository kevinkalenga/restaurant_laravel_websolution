<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReviewInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Donnez votre avis sur votre commande #' . $this->order->invoice_id,
            to: $this->order->user->email
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.order-review-invitation-mail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
