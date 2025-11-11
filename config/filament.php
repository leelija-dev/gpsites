<?php

return [
    // Minimal Filament config override — only the auth section is required here
    'auth' => [
        // Use your admin guard
        'guard' => 'admin',

        // Ensure Filament uses the admins provider
        'provider' => 'admins',

        // Ensure Filament's auth middleware uses Filament's Authenticate middleware with the admin guard
        'middleware' => [
            'auth'  => \Filament\Http\Middleware\Authenticate::class . ':admin',
        ],
    ],
];

