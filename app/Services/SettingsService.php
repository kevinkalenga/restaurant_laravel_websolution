<?php  

namespace App\Services; 
use Cache;
use App\Models\Setting;



class SettingsService {
    function getSettings()
    {
      return Cache::rememberForever('settings', function () {
          return Setting::pluck('value', 'key')->toArray();
      });
    }

    // function setGlobalSettings() 
    // {
    //     $settings = $this->getSettings();
    //     config()->set('settings', $settings);
    // }

    
    function setGlobalSettings()
    {
        $settings = $this->getSettings();

        config()->set('settings', $settings);

        config([
            'mail.default' => $settings['mail_driver'] ?? 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => $settings['mail_host'] ?? 'smtp.gmail.com',
            'mail.mailers.smtp.port' => (int) ($settings['mail_port'] ?? 587),
            'mail.mailers.smtp.username' => $settings['mail_username'] ?? null,
            'mail.mailers.smtp.password' => $settings['mail_password'] ?? null,
            'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?? 'tls',
            'mail.from.address' => $settings['mail_from_address'] ?? null,
            'mail.from.name' => $settings['site_name'] ?? config('app.name'),
        ]);
    }


    function clearCachedSettings()
    {
        Cache::forget('settings');
    }
}