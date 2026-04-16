<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
      return view('admin.setting.index');
    }
    
    public function UpdateGeneralSetting(Request $request)
    {
      dd($request->all());
    }
}
