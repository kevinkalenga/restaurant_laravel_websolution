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
       return $id;
    }
}
