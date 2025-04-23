<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
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

    'authorize_net' => [
        'api_login_id' => env('ANET_API_LOGIN_ID'),
        'transaction_key' => env('ANET_TRANSACTION_KEY'),
    ],

    'elavon' => [
        'merchant_id' => env('ELAVON_MERCHANT_ID'),
        'account' => env('ELAVON_ACCOUNT'),
        'pass' => env('ELAVON_PASS'),
        'url' => env('ELAVON_URL'),
    ],

    'moneris' => [
        'store' => env('MONERIS_STORE_ID'),
        'token' => env('MONERIS_API_TOKEN'),
        'checkout' => env('MONERIS_CHECKOUT'),
        'test' => [
            'store' => 'store3',
            'token' => 'yesguy',
            'checkout' => 'chktAJFFRtore3',
        ],
    ],

    'cloudflare' => [
        'turnstile_site_key' => env('TURNSTILE_SITE_KEY'),
        'turnstile_secret_key' => env('TURNSTILE_SECRET_KEY'),
    ],

    'datafeed' => [
        'token' => env('DATA_FEED_API_KEY'),
        'email' => env('DATA_FEED_API_EMAIL'),
    ],

];
