<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCancellationContactMail extends Mailable
{
    use Queueable, SerializesModels;

        public function __construct(
        public Order $order,
        public string $cancellationReason
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Concernant votre commande ' . $this->order->invoice_id
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.order-cancellation-contact-mail'
        );
    }
}