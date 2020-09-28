<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],
    'facebook' => [
        'client_id' => '2100067910309440',         // Your GitHub Client ID
        'client_secret' => '4b69b161706a585497e1107a7c94ff9d', // Your GitHub Client Secret
        'redirect' => 'https://xn--danhmc-mq8b.vn/facebook/callback',
    ],
     'google' => [
        'client_id' => '550695388775-hcp3v0e6k4hgsajnioquu60p312lhlvv.apps.googleusercontent.com',         // Your GitHub Client ID
        'client_secret' => 'O-oY7CSz5arteXKRhz704Svt', // Your GitHub Client Secret
        'redirect' => 'https://xn--danhmc-mq8b.vn/google/callback',
    ],
];
