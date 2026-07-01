<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryArea;
class DashboardController extends Controller
{
   public function index() 
   {
    $deliveryAreas = DeliveryArea::where('status', 1)->get();
     return view('frontend.dashboard.index', compact("deliveryAreas"));
   }

   public function createAddress(Request $request)
   {
      // dd($request->all());
   }
}
