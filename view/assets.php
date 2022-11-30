<?php

function asset($file)
{
    return '//' . $_SERVER['HTTP_HOST'] . '/resources/assets/' . $file;
}

function node($file)
{
    return '//' . $_SERVER['HTTP_HOST'] . '/node_modules/' . $file;
}
