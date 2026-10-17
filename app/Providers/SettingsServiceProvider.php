<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SettingsService;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingsService::class, function(){
            return new SettingsService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->environment('testing')) {
            return;
        }

        if (!\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            return;
        }

        $settingsService = $this->app->make(SettingsService::class);
        $settingsService->setGlobalSettings();
    }
}
