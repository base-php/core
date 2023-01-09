<?php

$capsule = new Illuminate\Database\Capsule\Manager;

$root = (php_sapi_name() == 'cli') ? '' : $_SERVER['DOCUMENT_ROOT'] . '/';

$config = require $root . 'app/config.php';

foreach ($config['database'] as $item) {
    $database = ($item['driver'] == 'sqlite') ? $item['database'] . '.sqlite' : $item['database'];

    $capsule->addConnection([
        'driver' => $item['driver'],
        'host' => $item['host'],
        'database' => $database,
        'username' => $item['username'],
        'password' => $item['password'],
        'port' => $item['port'],
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
        'strict' => false
    ], $item['name']);
}

$capsule->setAsGlobal();
$capsule->bootEloquent();
