<?php

/**
 * Generate an asset path for the application.
 *
 * @param  string  $path
 * @return string
 */
function asset($file)
{
    echo '//' . $_SERVER['HTTP_HOST'] . '/resources/assets/' . $file;
}

function node($file)
{
	echo '//' . $_SERVER['HTTP_HOST'] . '/node_modules/' . $file;
}
