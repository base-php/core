<?php

function debugbar($message)
{
    $_ENV['debugbar'][] = $message;
}

function localhost()
{
    if (strpos($_SERVER['HTTP_HOST'], 'localhost')) {
        return true;
    }
    return false;
}
