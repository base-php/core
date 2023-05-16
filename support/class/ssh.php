<?php

use Spatie\Ssh\Ssh AS SpatieSsh;

class SSH
{
	public $instance;

	public function __construct()
    {
        if (! class_exists('Spatie\Ssh\Ssh')) {
            throw new Exception("Please execute 'composer require spatie/ssh' in console.");
        }
    }

    public function login($user, $pass, $port = 22)
    {
    	$this->instance = SpatieSsh::create($user, $pass, $port);
    	return $this;
    }

    public function exec($command)
    {
    	$this->instance->execute($command);
    	return $this;
    }
}