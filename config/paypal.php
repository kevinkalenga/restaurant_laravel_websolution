<?php

return [

    'mode' => 'sandbox',

    'sandbox' => [
        'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
        'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET'),
        'app_id' => '',
    ],

    'live' => [
        'client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
        'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET'),
        'app_id' => '',
    ],

    'payment_action' => 'Capture',

    'currency' => 'USD',

    'notify_url' => '',

    'locale' => 'en_US',

    'validate_ssl' => true,

];
