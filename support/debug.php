<?php

function localhost()
{
    if (strpos($_SERVER['HTTP_HOST'], 'localhost')) {
        return true;
    }

    return false;
}
