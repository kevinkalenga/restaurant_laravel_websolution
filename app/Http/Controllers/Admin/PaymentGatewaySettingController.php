<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentGatewaySettingController extends Controller
{
    public function index()
    {
        return view('admin.payment-setting.index');
    }

    public function paypalSettingUpdate(Request $request)
    {
        // dd($request->all());
    }
}
