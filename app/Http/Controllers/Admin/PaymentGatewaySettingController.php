<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentGatewaySetting;
use App\Traits\FileUploadTrait;

class PaymentGatewaySettingController extends Controller
{
    
    use FileUploadTrait;

    public function index()
    {
        $paymentGateway = PaymentGatewaySetting::pluck('value', 'key');
        //dd($paymentGateway);
        return view('admin.payment-setting.index', compact('paymentGateway'));
    }

    public function paypalSettingUpdate(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'paypal_status' => ['required', 'boolean'],
            'paypal_account_mode' => ['required', 'in:sandbox,live'],
            'paypal_country' => ['required'],
            'paypal_currency' => ['required'],
            'paypal_rate' => ['required', 'numeric'],
            'paypal_api_key' => ['required'],
            'paypal_secret_key' => ['required'],
            
        ]);

        if($request->hasFile('paypal_logo')) {
             $request->validate([
                'paypal_logo' => ["nullable", "image"]
             ]);

             $imgPath = $this->uploadImage($request, 'paypal_logo');

            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'paypal_logo'],
                ['value' => $imgPath]
            );
        }

        
        
        
        
        foreach ($validatedData as $key => $value) {
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        
        return redirect()->back()->with('success', 'Paypal Gateway Setting successfully!');
    }
}
