<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Services\SettingsService;

class SettingController extends Controller
{
    public function index()
    {
      return view('admin.setting.index');
    }
    
    public function updateGeneralSetting(Request $request)
   {
    $data = $request->validate([
        'site_name' => 'required|string|max:255',
        'site_default_currency' => 'required|string|size:3',
        'site_currency_icon' => 'required|string|max:10',
        'site_currency_icon_position' => 'required|in:left,right',
    ]);

    foreach ($data as $key => $value) {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    $settingsService = app(SettingsService::class);
    $settingsService->clearCachedSettings();

    return back()->with('success', 'Settings updated successfully.');
   }
}
