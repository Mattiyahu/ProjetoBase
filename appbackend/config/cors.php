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

    'allowed_origins' => ['http://localhost:5173', 'http://localhost:3000', 'http://localhost:5174', 'http://localhost:8000'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Authorization',
        'Accept',
        'Origin',
        'X-CSRF-TOKEN',
        'X-XSRF-TOKEN',
        'X-Socket-ID',
        'Access-Control-Allow-Origin',
        'Access-Control-Allow-Credentials'
    ],

    'exposed_headers' => ['Authorization'],

    'max_age' => 86400,  // 24 hours in seconds

    'supports_credentials' => true,

    'paths_patterns' => [
        '^/api/' => true,
        '^/sanctum/csrf-cookie' => true,
    ],
];
