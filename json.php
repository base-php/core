<?php

/**
 * Encode or decode a object, array or json.
 *
 * @param  $structure mixed
 * @return mixed
 */
function json($structure)
{
    if (is_array($structure) || is_object($structure)) {
        return json_encode($structure);
    }
    return json_decode($structure);
}
