<?php

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

    // Guard API
    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ]
    ],

    // Provider User
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\Models\User::class
        ]
    ]
];