<?php

/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
|
| Here are each of the database connections setup for your application.
|
| All database work is done through the PHP PDO facilities
| so make sure you have the driver for your particular database of
| choice installed on your machine before you begin development.
|
*/

$config = require('app/config.php');

$capsule = new Illuminate\Database\Capsule\Manager;

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
        'strict'	=> false
    ], $item['name']);
}

$capsule->setAsGlobal();
$capsule->bootEloquent();
