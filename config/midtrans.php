<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Midtrans Payment Gateway (Sandbox / Production).
    | Server key is strictly kept server-side and never exposed to the client.
    |
    */

    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => (bool) env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => (bool) env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => (bool) env('MIDTRANS_IS_3DS', true),
];
