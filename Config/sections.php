<?php

return [
    'sections' => [
        'app' => [
            'login' => [
                'route_login' => 'app.login',
                'show_login_form' => 'app.layout.login',
                'logged_out' => '/app/login',
                'guard' => 'app_web',
                'redirect_login' => 'app.user.index'
            ],
            'password' => [
                'route_email' => 'app.password.email',
                'route_request' => 'app.password.request',
                'route_update' => 'app.password.update',
            ],
            'layout' => 'app.layout.theme'
        ],
        'admin' => [
            'login' => [
                'route_login' => 'admin.login',
                'show_login_form' => 'admin.layout.login',
                'logged_out' => '/admin/login',
                'guard' => 'admin_web',
                'redirect_login' => 'admin.user.index'
            ],
            'password' => [
                'route_email' => 'admin.password.email',
                'route_request' => 'admin.password.request',
                'route_update' => 'admin.password.update',
            ],
            'layout' => 'admin.layout.theme'
        ]
    ]
];
