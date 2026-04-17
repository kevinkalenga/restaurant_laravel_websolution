<?php  

namespace App\Services; 
use Cach;
use App\Models\Setting;


class SettingsService {
    function getSettings()
    {
      return Cache::rememberForever('settings', function () {
          return Setting::pluck('value', 'key')->toArray();
      });
    }

    function setGlobalSettings() 
    {
        $settings = $this->getSettings();
        config()->set('settings', $settings);
    }

    function clearCachedSettings()
    {
        Cach::forget('settings');
    }
}