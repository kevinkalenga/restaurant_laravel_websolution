<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


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
        $provider = new PayPalClient();

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

        return redirect($approvalUrl);
    }
    public function paypalSuccess(Request $request)
    {
       $config = $this->setPaypalConfig();
       $provider = new PayPalClient($config);
       $provider->getAccessToken();

       $response = $provider->capturePaymentOrder($request->token);

       if(isset($response['status']) && $response['status'] === 'COMPLETED') {
         dd('Payment Completed');
       }
    }
    public function paypalCancel()
    {

    }
}
