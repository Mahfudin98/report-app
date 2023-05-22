<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        env('REPORT_CS_URL', 'https://ui-test.lsskincare.id'),
        env('DASHBORAR_URL', 'https://dashboard.lsskincare.id'),
        env('LANDINGPAGE_PUSAT', 'https://pusat.lsskincare.id'),
        env('LANDINGPAGE_FORMEN', 'https://formen.lsskincare.id'),
        env('LOCAL_FRONTEN', 'http://localhost:3000'),
        env('LOCAL_FRONTEN1', 'http://localhost:3001'),
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
