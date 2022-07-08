<?php

class Session
{
    public function all()
    {
        return $_SESSION;
    }

    public function delete($key = '')
    {
        if ($key != '') {
            unset($_SESSION[$key]);
            return 1;
        }

        unset($_SESSION);
        return 1;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
        return $value;
    }
}
