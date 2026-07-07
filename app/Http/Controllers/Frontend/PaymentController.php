<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
