<?php

return [
    'image' => 'postgres',
    'ports' => ['5432:5432'],
    'environment' => [
        'PGPASSWORD' => 'docker',
        'POSTGRES_DB' => 'base',
        'POSTGRES_USER' => 'root',
        'POSTGRES_PASSWORD' => 'docker'
    ],
    'volumes' => [
        'persistent-pgsql:/var/lib/postgresql/data'
    ],
    'networks' => ['default'],
];
