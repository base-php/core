<?php

$capsule = new Illuminate\Database\Capsule\Manager;

$config = require 'app/config.php';

foreach ($config['database'] as $item) {
    $driver = ($item['driver'] == 'sqlite') ? $item['driver'] . '.sqlite' : $item['driver'];

    $capsule->addConnection([
        'driver'    => $driver,
        'host'      => $item['host'],
        'database'  => $item['database'],
        'username'  => $item['username'],
        'password'  => $item['password'],
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
        'strict'    => false
    ], $item['name']);
}

$capsule->setAsGlobal();
$capsule->bootEloquent();
