<?php

/**
 * Get var of the config file.
 *
 * @param  string $var
 * @return string|object
 */

function config(string $var): string|object
{
	if (isset($_ENV[$var]) && $_ENV[$var] != '') {
		if (is_array($_ENV[$var])) {
			return (object) $_ENV[$var];
		}

		return $_ENV[$var];
	}
}