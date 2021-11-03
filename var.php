<?php

function option($var1, $var2)
{
    if (isset($var1) && $var1 != '') {
        return $var1;
    } else {
        return $var2;
    }
}

function set($var)
{
    if (isset($var) && $var != '') {
        return $var;
    }
}
