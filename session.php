<?php

function session($key = '', $value = '')
{
    if ($key && $value) {
        $_SESSION[$key] = $value;
        return 1;
    }

    if ($key) {
        return $_SESSION[$key] ?? null;
    }

    return $_SESSION;
}
