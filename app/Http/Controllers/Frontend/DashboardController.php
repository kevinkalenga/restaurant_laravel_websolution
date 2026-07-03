<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryArea;
use App\Models\Address;
use Auth;

class DashboardController extends Controller
{
   public function index() 
   {
      // comparer le current user avec celui qui est en bd
      $deliveryAreas = DeliveryArea::where('status', 1)->get();
   
      $userAddresses = Address::where('user_id', Auth()->user()->id)->get();
      return view('frontend.dashboard.index', compact("deliveryAreas", "userAddresses"));
   }

   public function createAddress(Request $request)
   {
      // dd($request->all());
        // Validation
    $request->validate([
        'delivery_area_id' => ['required', 'integer'],
        'first_name' => ['required', 'max:255'],
        'last_name' => ['nullable', 'max:255'],
        'phone' => ['required', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'address' => ['required'],
        'type' => ['required', 'in:home,office'],
        
      ]);

      $address = new Address();
      $address->user_id = Auth()->user()->id;
      $address->delivery_area_id = $request->delivery_area_id;
      $address->first_name = $request->first_name;
      $address->last_name = $request->last_name;
      $address->email = $request->email;
      $address->phone = $request->phone;
      $address->address = $request->address;
      $address->type = $request->type;

      $address->save();


      return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Address created successfully!');
   }

   public function updateAddress(Request $request, $id)
   {
      $address = Address::where('id', $id)
         ->where('user_id', auth()->id())
         ->firstOrFail();

      $request->validate([
         'delivery_area_id' => ['required', 'integer'],
         'first_name'       => ['required', 'max:255'],
         'last_name'        => ['nullable', 'max:255'],
         'phone'            => ['required', 'max:255'],
         'email'            => ['required', 'email', 'max:255'],
         'address'          => ['required'],
         'type'             => ['required', 'in:home,office'],
      ]);

      $address->delivery_area_id = $request->delivery_area_id;
      $address->first_name = $request->first_name;
      $address->last_name = $request->last_name;
      $address->phone = $request->phone;
      $address->email = $request->email;
      $address->address = $request->address;
      $address->type = $request->type;

      $address->save();

      return redirect()
         ->route('dashboard')
         ->with('success', 'Address updated successfully!');
   }
}
