<?php

return [

    'default' => env('DB_CONNECTION', 'mysql'),

    'connections' => [

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'moviegenie'),
            'username' => env('DB_USERNAME', 'jetvon'),
            'password' => env('DB_PASSWORD', '143_JetherVoughn'),
            'unix_socket' => env('DB_SOCKET', '/cloudsql/moviegenie-427106:asia-southeast1:moviegenie'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        // Other connections if needed

    ],

    // Other configurations

];
