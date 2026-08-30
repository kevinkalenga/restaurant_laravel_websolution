<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

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
        $keys = [
            'pusher_app_id',
            'pusher_cluster',
            'pusher_key',
            'pusher_secret',
        ];

        $pusherConf = Setting::whereIn('key', $keys)
            ->pluck('value', 'key');

        config([
            'broadcasting.default' => 'pusher',

            'broadcasting.connections.pusher.key' =>
                $pusherConf['pusher_key'] ?? null,

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
