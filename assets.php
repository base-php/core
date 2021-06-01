<?php

/**
 * Generate an asset path for the application.
 *
 * @param  string  $file
 * @return string
 */
function asset($file)
{
    echo '//' . $_SERVER['HTTP_HOST'] . '/resources/assets/' . $file;
}

/**
 * Generate an node path for the application.
 *
 * @param  string  $file
 * @return string
 */
function node($file)
{
	echo '//' . $_SERVER['HTTP_HOST'] . '/node_modules/' . $file;
}
