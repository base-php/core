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
            return;
        }

        unset($_SESSION);
        session_destroy();
    }

    public function flash($key, $value)
    {
        $_SESSION['flashmessages'][$key] = $value;
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
