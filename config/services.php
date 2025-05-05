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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    
     'firebase' => [
        'credentials' => env('FIREBASE_CREDENTIALS'),
    ],
    'visoon'=>[
        'GOOGLE_APPLICATION_CREDENTIALS'=> env('GOOGLE_APPLICATION_CREDENTIALS'),
    ],
    'microsoft' => [
    'client_id' => env('MICROSOFT_CLIENT_ID'),
    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
    'redirect' => env('MICROSOFT_REDIRECT_URI'),
],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_id_mobile' => env('GOOGLE_CLIENT_ID_mobile'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URL'),
    ],
'microsoft' => [    
        'client_id' => '79081f9e-cce9-49b4-9200-41f36941e8cd',  
        'client_secret' => env('AZURE_CLIENT_SECRET'),  
        'redirect' => env('AZURE_REDIRECT_URI'),
        'tenant' => env('AZURE_TENANT_ID','common'),
        // 'proxy' => env('PROXY')  // Optional, will be used for all requests
],
    
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URL'),
        'client_id_mobile' => env('FACEBOOK_CLIENT_ID_mobile'),
        'client_secret_mobile' => env('FACEBOOK_CLIENT_SECRET_mobile'),

    ],
    
    'instagram' => [
        'client_id' => env('INSTAGRAM_CLIENT_ID'),
        'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),
        'redirect' => env('INSTAGRAM_REDIRECT_URL'),
    ],
    
    'apple' => [
        'client_id' => env('APPLE_CLIENT_ID'),
        'client_secret' => env('APPLE_CLIENT_SECRET'),
        'redirect' => env('APPLE_REDIRECT_URL'),
    ],

    'sportmonks_api_token' => env('SPORTMONKS_API_TOKEN', 'default_value_if_any'),

    'agora_app_id'=>env('AGORA_APP_ID'),
    'agora_app_certificate'=>env('AGORA_APP_CERTIFICATE'),

];
