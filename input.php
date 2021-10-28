<?php

function checked($key, $value)
{
    if (is_array($key)) {
        foreach ($key as $item) {
            if ($item == $value) {
                echo 'checked';
            }
        }
    } else {
        echo (isset($key) && $key == $value) ? 'checked' : '';
    }
}

function selected($key, $value)
{
    if (is_array($key)) {
        foreach ($key as $item) {
            if ($item == $value) {
                echo 'selected';
            }
        }
    } else {
        echo (isset($key) && $key == $value) ? 'selected' : '';
    }
}
