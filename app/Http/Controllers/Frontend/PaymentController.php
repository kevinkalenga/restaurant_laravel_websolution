<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;

class PaymentController extends Controller
{
    public function index()
    {
        if (
                count(session('cart', [])) === 0 ||
                !session()->has('delivery_fee') ||
                !session()->has('address')
            ) {
                return redirect()->route('checkout')
                    ->with('error', 'Please complete the checkout information first.');
        }
    
        $subTotal = cartTotal();
        $delivery = session()->get('delivery_fee', 0);
        $discount = session()->get('coupon')['discount'] ?? 0;

        $finalTotal = ($subTotal + $delivery) - $discount;

        return view('frontend.pages.payment', compact(
            'subTotal',
            'delivery',
            'discount',
            'finalTotal'
        ));
    }

    public function makePayment(Request $request, OrderService $orderService)
    {
       $request->validate([
         'payment_gateway' => ['required', 'string', 'in:paypal']
       ]);

       // Create Order   

       

       try {

           $order = $orderService->createOrder();

            // redirect user to the payment host
            if (!$order) {
                return response()->json([
                    'message' => 'Failed to create order.'
                ], 500);
            }
             
            switch ($request->payment_gateway) {

                case 'paypal':
                    return response()->json([
                        'redirect_url' => route('paypal.payment')
                    ]);

                default:
                    return response()->json([
                        'message' => 'Unsupported payment gateway.'
                    ], 400);
            }
         
          
       }catch(\Exception $e) {
          
          return response()->json([
            'message' => 'Payment could not be processed. Please try again.'
          ], 500);
       }

     
    }

    public function payWithPaypal()
    {
        return 'Payment processing';
    }
    public function paypalSuccess()
    {

    }
    public function paypalCancel()
    {

    }
}
