<?php

namespace App\Listeners;

use App\Events\OrderPaymentUpdateEvent;
use App\Models\Order;

class OrderPaymentUpdateListener
{
    public function handle(OrderPaymentUpdateEvent $event): void
    {
        $order = Order::find($event->orderId);

        if (!$order) {
            \Log::warning('Payment update skipped: order not found.', [
                'order_id' => $event->orderId,
            ]);

            return;
        }

        $paymentInfo = $event->paymentInfo;

        // Only mark the order as completed after a confirmed payment.
        $confirmedStatuses = ['COMPLETED', 'paid'];

        if (!isset($paymentInfo['status']) ||
            !in_array($paymentInfo['status'], $confirmedStatuses, true)) {
            \Log::warning('Payment update skipped: unconfirmed payment status.', [
                'order_id' => $event->orderId,
                'status' => $paymentInfo['status'] ?? null,
            ]);

            return;
        }

        $order->payment_method = $event->paymentMethod;
        $order->payment_status = 'completed';
        $order->payment_approve_date = now();
        $order->transaction_id = $paymentInfo['transaction_id'] ?? null;
        $order->currency_name = $paymentInfo['currency'] ?? null;
        $order->save();
    }
}
