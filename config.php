<?php

/**
 * Get var of the config file.
 *
 * @param  string $var
 * @return string|array
 */

function config(string $var1, string $var2 = ''): string|array
{
	$config = $_ENV;
	
	if (isset($var2) && $var2 != '') {
		return $config[$var1][$var2];
	}

	return $config[$var1];
}