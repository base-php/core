<?php

use Carbon\Carbon;

function lang($key)
{
    try {
    	$array = explode('.', $key);

    	$file = $array[0];
    	$key = $array[1];

    	return $_ENV['translate'][$file][$key];
    } catch (Exception $e) {
        return $key;
    }
}
