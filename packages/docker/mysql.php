<?php

return [
    'image' => 'mysql',
    'ports' => ['3306:3306'],
    'environment' => [
        'MYSQL_DATABASE' => 'base',
        'MYSQL_PASSWORD' => 'docker',
        'MYSQL_ROOT_PASSWORD' => 'docker',
    ],
    'volumes' => [
        './vendor/base-php/core/tmp:/etc/mysql/conf.d',
        'persistent-mysql:/var/lib/mysql'
    ],
    'networks' => ['default'],
];
