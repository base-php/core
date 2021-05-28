<?php

/**
 * Verify if variable is defined and is not empty.
 *
 * @param  mixed $var
 * @return string
 */
function set($var)
{
    if (isset($var) && $var != '') {
        return $var;
    }
}

/**
 * Return variable one if exists and not if empty, else return variable two.
 *
 * @param  string $var1
 * @param  string $var2
 * @return string
 */
function optionals($var1, $var2)
{
    if (isset($var1) && $var1 != '') {
        return $var1;
    } else {
        return $var2;
    }
}
