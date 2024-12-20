<?php

return [
    'services' => [
        'apache' => [
            'build' => './vendor/base-php/core/packages/docker',
            'ports' => ['80:80'],
            'volumes' => ['.:/var/www/html'],
            'networks' => ['default'],
        ],
    ]
];
