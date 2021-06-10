<?php

return [
    'db'               => [
        'user'     => 'root',
        'password' => '',
        'host'     => 'localhost',
        'db_name'  => 'test',
    ],
    'namespace'        => 'App\Controllers',
    'view_path'        => dirname(__DIR__) . '/views',
    'layout_path' => dirname(__DIR__) . '/views/layouts',
    'url_manager'      => [
        'test' => 'site/test'
    ],
];