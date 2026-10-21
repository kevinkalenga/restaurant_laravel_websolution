<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use App\Services\SettingsService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        if ($this->app->environment('testing')) {
            return;
        }

        $keys = [
            'pusher_app_id',
            'pusher_cluster',
            'pusher_key',
            'pusher_secret',
        ];

        if (!\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            return;
        }

        
        $settings = app(SettingsService::class)->getSettings();

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
        
        
        
        
        
        $pusherConf = Setting::whereIn('key', $keys)
          ->pluck('value', 'key');

        if (empty($pusherConf['pusher_key'])) {
            return;
        };

        config([
            'broadcasting.default' => 'pusher',

            'broadcasting.connections.pusher.key' =>
                $pusherConf['pusher_key'],

            'broadcasting.connections.pusher.secret' =>
                $pusherConf['pusher_secret'] ?? null,

            'broadcasting.connections.pusher.app_id' =>
                $pusherConf['pusher_app_id'] ?? null,

            'broadcasting.connections.pusher.options.cluster' =>
                $pusherConf['pusher_cluster'] ?? null,

            'broadcasting.connections.pusher.options.useTLS' => true,

            'broadcasting.connections.pusher.options.host' => 'api-eu.pusher.com',
        ]);
    }
}
