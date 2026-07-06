<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\DeliveryArea;
use Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth()->user()->id)->get();
         $deliveryAreas = DeliveryArea::where('status', 1)->get();
        return view('frontend.pages.checkout', compact('addresses', 'deliveryAreas'));
    }

    public function calculationDeliveryCharge($id)
    {
        try{

               $address = Address::findOrFail($id);
               $deliveryFee = $address->deliveryArea?->delivery_fee ?? 0;
                //dd($deliveryFee);
                $subtotal = cartTotal();

                $discount = session('coupon.discount', 0);

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

        session(['address' => $selectedAddress]);

        return response()->json([
            'redirect_url' => route('payment.index')
        ]);
    }
}
