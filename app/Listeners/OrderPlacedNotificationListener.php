<?php

namespace App\Listeners;

use App\Events\OrderPlacedNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use Mail;

class OrderPlacedNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    // public function handle(OrderPlacedNotificationEvent $event): void
    // {
    //     $orderId = $event->orderId;
    //     // relationship(user)
    //     $order = Order::with('user')->find($orderId);

    //     Mail::send(new OrderPlacedMail($order));
    // }

    public function handle(OrderPlacedNotificationEvent $event): void
    {
        $order = Order::with('user')->find($event->orderId);

        \Log::info('Order mail debug', [
            'order_id' => $order->id,
            'user_email' => $order->user->email ?? 'NO EMAIL'
        ]);

        Mail::send(new OrderPlacedMail($order));
    }
}
