<?php

return [
    'image' => 'mysql',
    'ports' => ['3306:3306'],
    'environment' => [
        'MYSQL_DATABASE' => '${MYSQL_DATABASE}',
        'MYSQL_PASSWORD' => '${MYSQL_PASSWORD}',
        'MYSQL_ROOT_PASSWORD' => '${MYSQL_PASSWORD}',
    ],
    'volumes' => [
        './vendor/base-php/core/tmp:/etc/mysql/conf.d',
        'persistent:/var/lib/mysql'
    ],
    'networks' => 'default',
];
