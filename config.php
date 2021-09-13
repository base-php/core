<?php

/**
 * Get var of the config file.
 *
 * @param  string $var
 * @return string
 */

function config($var1, $var2 = '')
{
	$config = $_ENV;
	
	if (isset($var2) && $var2 != '') {
		return $config[$var1][$var2];
	}

	return $config[$var1];
}