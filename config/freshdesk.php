<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Freshdesk credentials
    |--------------------------------------------------------------------------
    |
    | Your API key (Profile settings > API key) and the subdomain of your
    | helpdesk: for https://acme.freshdesk.com the domain is "acme".
    |
    */

    'api_key' => env('FRESHDESK_API_KEY'),

    'domain' => env('FRESHDESK_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | HTTP client options
    |--------------------------------------------------------------------------
    |
    | Extra Guzzle options passed to the SDK client. Authentication cannot be
    | overridden here. Times are in seconds.
    |
    */

    'http' => [
        'timeout' => (float) env('FRESHDESK_TIMEOUT', 30),
        'connect_timeout' => (float) env('FRESHDESK_CONNECT_TIMEOUT', 10),
    ],

];
