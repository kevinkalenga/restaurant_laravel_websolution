<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EquipmentReturnMail extends Mailable
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
            subject: 'Restitution du matériel prêté - Commande #' . $this->order->invoice_id,
            to: $this->order->user->email
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.equipment-return-mail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
