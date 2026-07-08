<?php  

namespace App\Services; 
use Auth;
use Cart;
use App\Models\Order;



class OrderService {
    // Store Order In Database
    function createOrder()
    {
       $order = new Order();
       $order->invoice_id = generateInvoiceId();
       $order->user_id = Auth()->user()->id;
       $order->address = session()->get('address');
       $order->discount = session()->get('coupon')['discount'];
       $order->delivery_charge = session()->get('delivery_fee');
       $order->subtotal = cartTotal();
       $order->grand_total = cartTotal() - session('coupon.discount', 0) + session('delivery_fee', 0);
       $order->product_qty = Cart::content()->count();
       $order->payment_method = NULL;
       $order->payment_status = 'pending';
       $order->payment_approve_date = NULL;
       $order->transaction_id = NULL;
       $order->coupon_info = json_encode(session()->get('coupon'));
       $order->currency_name = NULL;
       $order->order_status = 'pending';
       $order->save();
    }

    // Clear Session Items

    function clearSession() 
    {
       
    }

    
}