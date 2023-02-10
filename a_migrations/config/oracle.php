<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', ''),
        'host'           => env('DB_HOST', '116.204.182.167'),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE', 'orcl'),
        'service_name'   => env('DB_SERVICENAME', 'orcl'),
        'username'       => env('DB_USERNAME', 'TCM_SA1'),
        'password'       => env('DB_PASSWORD', 'TCM_SA1'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
        'dynamic'        => [],
    ],
];
