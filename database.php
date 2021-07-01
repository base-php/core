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

$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
	'driver'    => config('database', 'driver'),
    'host'      => config('database', 'host'),
    'database'  => (config('database', 'driver') == 'sqlite') ? config('database', 'database') . '.sqlite' : config('database', 'database'),
    'username'  => config('database', 'username'),
    'password'  => config('database', 'password'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
    'strict'	=> false
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
