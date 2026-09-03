<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\OrderPlacedNotification;
use App\Events\RTOrderPlacedNotificationEvent;

class RTOrderPlacedNotificationListener
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
    public function handle(RTOrderPlacedNotificationEvent $event): void
    {
        $notification = new OrderPlacedNotification();
        $notification->message = $event->message;
        // orderId from the event
        $notification->order_id = $event->orderId;

        $notification->save();
    }
}
