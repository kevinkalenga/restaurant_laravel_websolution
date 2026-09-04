<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Events\OrderPaymentUpdateEvent;
use App\Events\OrderPlacedNotificationEvent;
use App\Events\RTOrderPlacedNotificationEvent;
use Stripe\StripeClient;
use App\Models\Order;


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
         'payment_gateway' => ['required', 'string', 'in:paypal,stripe']
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
                case 'stripe':
                    return response()->json([
                        'redirect_url' => route('stripe.payment')
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

    public function setPaypalConfig()
    {
        $settings = \App\Models\Setting::first();

        return [
            // 'mode' => $settings->paypal_mode,
            'mode' => config('gatewaySettings.paypal_account_mode'),

            'live' => [
                'client_id'     => config('gatewaySettings.paypal_api_key'),
                'client_secret' => config('gatewaySettings.paypal_secret_key'),
            ],

            'sandbox' => [
                'client_id'     => config('gatewaySettings.paypal_api_key'),
                'client_secret' => config('gatewaySettings.paypal_secret_key'),
            ],

            'payment_action' => 'Sale',
            'currency'       => config('gatewaySettings.paypal_currency'),
            'notify_url'     =>  url('/paypal/notify'),
            'locale'         => 'en_US',
            'validate_ssl'   => true,
        ];
    }
    
    
    public function payWithPaypal()
    {
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);

       $token = $provider->getAccessToken();

      

        // calculate payable amount 
        $grandTotal = session()->get('grand_total');
        $payableAmount = round($grandTotal * config('gatewaySettings.paypal_rate'), 2);

        $response = $provider->createOrder([
            'intent' => "CAPTURE",
            'application_context' => [
               'return_url' => route('paypal.success'),
               'cancel_url' => route('paypal.cancel')
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('gatewaySettings.paypal_currency'),
                        'value' => $payableAmount
                    ]
                ]
            ]
        ]);
        $approvalUrl = null;

        foreach ($response['links'] as $link) {
            if ($link['rel'] === 'approve') {
                $approvalUrl = $link['href'];
                break;
            }
        }

        if ($approvalUrl === null) {
            return redirect()->route('payment.cancel')->withErrors([
                'error' => $response['error']['message'] ?? 'An error occurred while creating your PayPal order. Please try again.'
            ]);
        }

        return redirect($approvalUrl);
    }
    public function paypalSuccess(Request $request, OrderService $orderService)
    {
       $config = $this->setPaypalConfig();
       $provider = new PayPalClient($config);
       $provider->getAccessToken();

       $response = $provider->capturePaymentOrder($request->token);

       if(isset($response['status']) && $response['status'] === 'COMPLETED') {
           //dd($response);
           $orderId = session()->get('order_id');
           $capture = $response['purchase_units'][0]['payments']['captures'][0];
           $paymentInfo = [
             'transaction_id' => $capture['id'],
             'currency' => $capture['amount']['currency_code'],
             'status' => $capture['status'],
           ];

           OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'PayPal');
           OrderPlacedNotificationEvent::dispatch($orderId);
           RTOrderPlacedNotificationEvent::dispatch(Order::find($orderId));

          // Clear session data 
          $orderService->clearSession();

           return redirect()->route('payment.success');

          //dd('success');
        
       } else {
           return redirect()->route('payment.cancel')->withErrors([
                'error' => $response['error']['message'] ?? 'An error occurred while processing your PayPal payment. Please try again.'
            ]);
       }
    }
    public function paypalCancel()
    {
     
      return redirect()->route('payment.cancel');
    }
    public function paymentSuccess()
    {
      return view('frontend.pages.payment-success');
    }
    public function paymentCancel()
    {
       
       return view('frontend.pages.payment-cancel');
    }

    // Stripe Payment
    public function payWithStripe()
    {
        
        $stripe = new StripeClient(config('gatewaySettings.stripe_secret_key'));

        //  dd(session('email'));

        // Exemple : créer une session Checkout
        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'customer_email' => session('email'),
            'line_items' => [[
                'price_data' => [
                    'currency' => config('gatewaySettings.stripe_currency'),
                    'product_data' => [
                        'name' => 'Order',
                    ],
                    'unit_amount' => (int) (session('grand_total') * 100), // en centimes
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);

        

        return redirect($session->url);
       
    }






    // public function stripeSuccess(Request $request, OrderService $orderService)
    // {
    //     $stripe = new StripeClient(config('gatewaySettings.stripe_secret_key'));

    //     $session = $stripe->checkout->sessions->retrieve($request->session_id);

    //     if ($session->payment_status === 'paid') {

    //         try {

    //             $orderId = session()->get('order_id');

    //             $paymentInfo = [
    //                 'transaction_id' => $session->payment_intent,
    //                 'currency' => $session->currency,
    //                 'status' => $session->payment_status,
    //             ];

    //             OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'Stripe');

    //             OrderPlacedNotificationEvent::dispatch($orderId);

    //             $orderService->clearSession();

    //             return redirect()->route('payment.success');

    //         } catch (\Exception $e) {

    //             dd([
    //                 'error' => $e->getMessage(),
    //                 'line' => $e->getLine(),
    //                 'file' => $e->getFile(),
    //                 'order_id' => session()->get('order_id'),
    //             ]);
    //         }
    //     }

    //     return redirect()->route('payment.cancel');
    // }


    public function stripeSuccess(Request $request, OrderService $orderService)
    {
        $stripe = new StripeClient(config('gatewaySettings.stripe_secret_key'));

        $session = $stripe->checkout->sessions->retrieve($request->session_id);

        if ($session->payment_status === 'paid') {

            $orderId = session()->get('order_id');

            $paymentInfo = [
                'transaction_id' => $session->payment_intent,
                'currency' => $session->currency,
                'status' => $session->payment_status,
            ];

            OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'Stripe');
            OrderPlacedNotificationEvent::dispatch($orderId);
            RTOrderPlacedNotificationEvent::dispatch(Order::find($orderId));

            $orderService->clearSession();

            return redirect()->route('payment.success');
        }

        return redirect()->route('payment.cancel');
    }


    public function stripeCancel()
    {
        return redirect()->route('payment.cancel');
    }
}
