<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mode PayDunya : 'test' ou 'live'
    |--------------------------------------------------------------------------
    */
    'mode' => env('PAYDUNYA_MODE', 'test'),

    /*
    |--------------------------------------------------------------------------
    | Clés API PayDunya
    |--------------------------------------------------------------------------
    */
    'master_key'  => env('PAYDUNYA_MASTER_KEY', ''),
    'private_key' => env('PAYDUNYA_PRIVATE_KEY', ''),
    'token'       => env('PAYDUNYA_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Infos de la boutique affichées sur la page PayDunya
    |--------------------------------------------------------------------------
    */
    'store_name'    => env('PAYDUNYA_STORE_NAME', 'United Kizdom World Congress'),
    'store_tagline' => env('PAYDUNYA_STORE_TAGLINE', 'Festival de danse kizomba'),
    'store_address' => env('PAYDUNYA_STORE_ADDRESS', 'Cotonou, Bénin'),
    'store_website' => env('PAYDUNYA_STORE_WEBSITE', env('FRONTEND_URL', 'http://localhost:3000')),

    /*
    |--------------------------------------------------------------------------
    | URLs de redirection
    |--------------------------------------------------------------------------
    */
    'return_url'   => env('PAYDUNYA_RETURN_URL', ''),
    'cancel_url'   => env('PAYDUNYA_CANCEL_URL', ''),
    'callback_url' => env('PAYDUNYA_CALLBACK_URL', ''), // webhook IPN
];
