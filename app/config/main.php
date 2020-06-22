<?php

return [
    'view_path'   => dirname(__DIR__) . '/views',
    'layout_path' => dirname(__DIR__) . '/views/layout/',
    'url_manager' => [
        'hey' => 'site/test'
    ],
    'db'          => [
        'dbname'   => 'ppc',
        'host'     => 'localhost',
        'user'     => 'root',
        'password' => 'YOURNEWPASSWORD',
    ],
    'namespace'   => 'App\Controllers',
];