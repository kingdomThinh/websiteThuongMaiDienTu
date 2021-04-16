<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
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

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

  //   'google' => [
  //   'client_id' => '1031607041506-sqt6s3a26reamnlt2oeuc41cueqfstmr.apps.googleusercontent.com',
  //   'client_secret' => 'nmkO2S2yczsK7KMgBrp8CVoH',
  //   'redirect' => 'http://minitiki.com/callback/google',
  // ], 

    'facebook' => [
    'client_id' => env('3710349192321947'),
    'client_secret' => env('2fd305d88de62957b878794894a135b8'),
    'redirect' => env('http://minitiki.com/login/callback'),

    'google' => [
        'client_id' => 'app id',
        'client_secret' => 'add secret',
        'redirect' => 'http://learnl52.hd/auth/google/callback',
    ],
],
];
