<?php

function session($key = '', $value = '')
{
    if ($key != '' && $value != '') {
        return $_SESSION[$key] = $value;
    } elseif ($key != '' && isset($_SESSION[$key])) {
        return $_SESSION[$key];
    } else {
        return $_SESSION;
    }
}
