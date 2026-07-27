<?php  

namespace App\Services; 
use Auth;
use Cart;
use App\Models\Order;
use App\Models\OrderItem;



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
         $order->delivery_area_id = session()->get('delivery_area_id');
         $order->save();
         // Parcourir le panier et inserré le contenu dans OrderItem 
         foreach(Cart::content() as $product) {
            $orderItem = new OrderItem();
            // order_id fait reference à la table Order  
            $orderItem->order_id = $order->id;
            $orderItem->product_name = $product->name;
            $orderItem->product_id = $product->id;
            $orderItem->unit_price = $product->price;
            $orderItem->qty = $product->qty;
            $orderItem->product_size = json_encode($product->options->product_size);
            $orderItem->product_option = json_encode($product->options->product_options);

            $orderItem->save();
         }

        // Putting the order in the session
         session()->put('order_id', $order->id);
         
        // Putting the grand total amount in session
         session()->put('grand_total', $order->grand_total);
       
        

         return $order;
   
    }

    // Clear Session Items

    function clearSession() 
    {
       \Cart::destroy();
       session()->forget('coupon');
       session()->forget('address');
       session()->forget('delivery_fee');
       session()->forget('delivery_area_id');
       session()->forget('order_id');
       session()->forget('grand_total');
    }

    
}