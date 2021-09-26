<?php

/**
 * Set or get session variable.
 *
 * @param mixed $key
 * @param mixed $value
 * @return mixed
 */
function session(string $key = '', mixed $value = ''): mixed
{
    if ($key != '' && $value != '') {
        return $_SESSION[$key] = $value;
    } elseif ($key != '' && isset($_SESSION[$key])) {
        return $_SESSION[$key];
    } else {
        return $_SESSION;
    }
}
