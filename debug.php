<?php

/**
 * Show message in debugbar console.
 *
 * @param  mixed
 * @return void
 */
function debugbar($message)
{
    $_ENV['debugbar'][] = $message;
}

/**
 * Verify if the environment is local.
 *
 * @return bool
 */
function localhost()
{
    if (strpos($_SERVER['HTTP_HOST'], 'localhost')) {
        return true;
    }
    return false;
}
