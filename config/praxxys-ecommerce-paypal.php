<?php

return [

   /*
    |--------------------------------------------------------------------------
    | PayPal Settings
    |--------------------------------------------------------------------------
    */

    'gateway_url' => env('PRX_PAYPAL_ENV') === 'sandbox' ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr',

    'business' => env('PRX_PAYPAL_BUSINESS'),
    

   /*
    |--------------------------------------------------------------------------
    | General Settings
    |--------------------------------------------------------------------------
    */

    'return_route' => env('PRX_PAYPAL_RETURN_ROUTE'),

    'cancel_route' => env('PRX_PAYPAL_CANCEL_ROUTE'),

    'notify_route' => env('PRX_PAYPAL_NOTIFY_ROUTE', 'prx_paypal.notify_url'),

    'listener' => env('PRX_PAYPAL_LISTENER', '\App\Listeners\ProcessPayPal'),

];