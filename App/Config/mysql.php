<?php

return [
    'default' => [
        'dns' => 'mysql:host=127.0.0.1;dbname=lysy',
        'username' => 'root',
        'password' => '123456',
        'ops' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
        ]
    ]
];
