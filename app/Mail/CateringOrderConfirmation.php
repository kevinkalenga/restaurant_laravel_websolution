<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CateringOrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
        $this->order->loadMissing('cateringMenu');
    }

    public function build()
    {
        return $this->subject(
            'Confirmation de réception de votre commande traiteur'
        )->view('mail.catering.orders.confirmation');
    }
}
