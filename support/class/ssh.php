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

    public function exec($command)
    {
        $this->instance->execute($command);
        return $this;
    }

    public function login($user, $pass, $port = 22)
    {
    	$this->instance = SpatieSsh::create($user, $pass, $port);
    	return $this;
    }

    public function output()
    {
        return $this->instance->getOutput();
    }

    public function success()
    {
        return $this->instance->isSuccessful();
    }

    public function timeout($timeout)
    {
        $this->instance->setTimeout($timeout);
        return $this;
    }
}