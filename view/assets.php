<?php

function asset($file)
{
    if (config('environment') == 'development') {
        $file = $file . '?v=' . rand(0, 999999);
    }

    return '//'.$_SERVER['HTTP_HOST'].'/resources/assets/' . $file;
}

function node($file)
{
    return '//'.$_SERVER['HTTP_HOST'].'/node_modules/'.$file;
}
