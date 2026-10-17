<?php

namespace App\Providers;

use App\Services\PaymentGatewaySettingService;
use Illuminate\Support\ServiceProvider;

class PaymentGatewaySettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
         $this->app->singleton(PaymentGatewaySettingService::class, function(){
            return new PaymentGatewaySettingService();
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

        if (!\Illuminate\Support\Facades\Schema::hasTable('payment_gateway_settings')) {
            return;
        }

        $paymentGatewaySetting = $this->app->make(PaymentGatewaySettingService::class);
        $paymentGatewaySetting->setGlobalSettings();
    }
}
