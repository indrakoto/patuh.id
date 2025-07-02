<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Configuration
    |--------------------------------------------------------------------------
    |
    | This file is where you can configure your CORS settings for Laravel.
    | The CORS settings will be applied to all requests that the
    | application processes, including API routes.
    |
    */

    //'paths' => ['chatbotai'], // Akses untuk semua API yang memiliki prefiks api/* dan chatbotai
    'paths' => ['api/*', 'document/*', 'storage/*'],

    'allowed_methods' => ['*'], // Izinkan semua metode HTTP seperti POST, GET, dll

    'allowed_origins' => ['*'], // Ganti dengan ['https://www.domain.com'] jika ingin memverifikasi hanya domain kamu

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Mengizinkan semua headers untuk request

    'exposed_headers' => [],

    'max_age' => 0, // Tentukan berapa lama browser bisa menyimpan informasi CORS

    'supports_credentials' => false,
];
