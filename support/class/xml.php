<?php

class XML
{
    public $data;

    public function __construct($resource)
    {
        if (file_exists($resource)) {
            $string = simplexml_load_file($resource);
        } else {
            $string = simplexml_load_string($resource);
        }

        $json = json_encode($string);
        $this->data = json_decode($json, true);
    }

    public function all()
    {
        return (object) $this->data;
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }
}
