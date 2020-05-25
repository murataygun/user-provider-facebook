<?php
/*
 * laravel-packages - user-provider-facebook.php
 * Initial version by : murataygun
 * Initial version created on : 13.5.2020 21:05
 */

return [
    'facebook' => [
        'client_id'     => env('FACEBOOK_APP_ID', ''),
        'client_secret' => env('FACEBOOK_APP_SECRET', ''),
    ],
    'url' => [
        'endpoint'         => 'https://graph.facebook.com/me?fields=id,name,email&access_token=:access_token',
        'app_access_token' => 'https://graph.facebook.com/oauth/access_token?client_id=:client_id&client_secret=:client_secret&grant_type=client_credentials',
        'inspect'          => 'https://graph.facebook.com/debug_token?input_token=:access_token&access_token=:app_access_token'
    ]
];
