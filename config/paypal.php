<?php

return [
    'client_id' => env('PAYPAL_CLIENT_ID'),
    'client_secret' => env('PAYPAL_SECRET'),
    'mode' => env('PAYPAL_MODE', 'sandbox'),

    'urls' => [
        'sandbox' => 'https://api-m.sandbox.paypal.com',
        'live' => 'https://api-m.paypal.com'
    ],

    'webhook_id' => env('PAYPAL_WEBHOOK_ID'),

    'trial_plan_id' => env('TRIAL_PLAN_ID', 14),
];
