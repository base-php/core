<?php

class XML
{
    public function load($resource)
    {
        if (file_exists($resource)) {
            $xml = simplexml_load_file($resource);
        } else {
            $xml = simplexml_load_string($resource);
        }

        $json = json_encode($xml);
        return json_decode($json);
    }
}
