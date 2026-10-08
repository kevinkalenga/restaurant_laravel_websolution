<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\DeliveryArea;
use Auth;
use Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        // $addresses = Address::where('user_id', Auth()->user()->id)->get();
        //  $deliveryAreas = DeliveryArea::where('status', 1)->get();
        // return view('frontend.pages.checkout', compact('addresses', 'deliveryAreas'));

         $addresses = Address::where('user_id', Auth()->user()->id)->get();
        $deliveryAreas = DeliveryArea::where('status', 1)->get();

        $ecfDiscount = 0;

        foreach (Cart::content() as $item) {
            $product = \App\Models\Product::find($item->id);

            if ($product && $item->qty >= ($product->minimum_persons + 5)) {
                $productTotal = $item->price * $item->qty;
                $ecfDiscount += $productTotal * 0.10;
            }
        }

        $ecfDiscount = round($ecfDiscount, 2);

        session()->put('ecf_discount', $ecfDiscount);

        
        
        
        
        return view('frontend.pages.checkout', compact(
            'addresses',
            'deliveryAreas',
            'ecfDiscount'
        ));
    }

    public function calculationDeliveryCharge($id)
    {
        try{

               $address = Address::findOrFail($id);
               $deliveryFee = $address->deliveryArea?->delivery_fee ?? 0;
                //dd($deliveryFee);
                // $subtotal = cartTotal();

                // $discount = session('coupon.discount', 0);

                // $total = round($subtotal - $discount + $deliveryFee, 2);

                $subtotal = cartTotal();

                $couponDiscount = session('coupon.discount', 0);
                $ecfDiscount = session('ecf_discount', 0);

                $discount = $couponDiscount + $ecfDiscount;

                $total = round($subtotal - $discount + $deliveryFee, 2);

                return response()->json([
                    'delivery_fee' => $deliveryFee,
                    'discount'     => $discount,
                    'finalTotal'   => $total,
                ]);
            } catch (\Exception $e) {
                \Log::error('Delivery calculation error: '.$e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something went wrong'
                ], 500);
            }

       
    }

    public function checkoutRedirect(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer']
        ]);

        $address = Address::with('deliveryArea')->where('user_id', auth()->id())->findOrFail($request->id);

        $selectedAddress = $address->address . ', Area: ' . ($address->deliveryArea?->area_name ?? '');

        session([
            'address' => $selectedAddress,
            'email' => auth()->user()->email,
            'delivery_fee' => $address->deliveryArea->delivery_fee,
            'delivery_area_id' => $address->deliveryArea->id,
        ]);
         \Log::info(session()->all());
       

        return response()->json([
            'redirect_url' => route('payment.index')
        ]);
    }
}
