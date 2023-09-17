<?php

function json($structure)
{
    if (is_array($structure) || is_object($structure)) {
        return json_encode($structure);
    }

    return json_decode($structure, true);
}
