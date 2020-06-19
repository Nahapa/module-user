<?php

return [
    'defaults' => [
        'guard' => 'app_web',
        'passwords' => 'users',
    ],

    'guards' => [
        'app_web' => [
            'driver' => 'session',
            'provider' => 'tenants',
        ],

        'admin_web' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \Modules\User\App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'admin_provider',
            'model' => \Modules\User\App\Models\User::class,
        ],

        'tenants' => [
            'driver' => 'tenant_provider',
            'model' => \Modules\User\App\Models\User::class,
        ]
    ]
];
