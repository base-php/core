<?php

function asset($file)
{
    echo '//' . $_SERVER['HTTP_HOST'] . '/resources/assets/' . $file;
}

function node($file)
{
	echo '//' . $_SERVER['HTTP_HOST'] . '/node_modules/' . $file;
}
