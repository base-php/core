<?php

use Spatie\Ssh\Ssh AS SpatieSsh;

class SSH
{
	public $instance;

	public function __construct()
    {
        if (! class_exists('Spatie\Ssh\Ssh')) {
            exec('composer require spatie/ssh');
        }
    }

    public function download($file)
    {
        $this->instance->download($file, $path);
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

    public function privateKey($privateKey)
    {
        $this->instance->usePrivateKey($privateKey);
        return $this;
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

    public function upload($file)
    {
        $this->instance->upload($file, $path);
    }
}