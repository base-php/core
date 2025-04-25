<?php

use Spatie\ArrayToXml\ArrayToXml;

class XML
{
    public $data;

    public function __construct($resource)
    {
        if (file_exists($resource)) {
            $string = simplexml_load_file($resource);

            if (! $string) {
                return throw new Exception('File does not have a correct XML format.');
            }
        }

        if (is_string($resource)) {
            $resource = file_get_contents($resource);
            $string = simplexml_load_string($resource);

            if (! $string) {
                return throw new Exception('String does not have a correct XML format.');
            }
        }

        $json = json_encode($string);
        $this->data = json_decode($json, true);
    }

    public function all()
    {
        return (object) $this->data;
    }
    

    public function get($key)
    {
        return $this->data[$key] ?? null;
    }

    public function save($filename)
    {
        if (! class_exists('ArrayToXml')) {
            throw new Exception('Please execute `composer require spatie/array-to-xml`');
        }

        $data = ArrayToXml::convert($this->data);
        file_put_contents($filename, $data);
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }
}
