<?php  

namespace App\Services; 
use Cache;
use App\Models\PaymentGatewaySetting;




class PaymentGatewaySettingService {
    function getSettings()
    {
      return Cache::rememberForever('gatewaySettings', function () {
          return PaymentGatewaySetting::pluck('value', 'key')->toArray();
      });
    }

    function setGlobalSettings() 
    {
        $settings = $this->getSettings();
        config()->set('gatewaySettings', $settings);
    }

    function clearCachedSettings()
    {
        Cache::forget('gatewaySettings');
    }
}