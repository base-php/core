<?php

use Carbon\Carbon;

function age($date)
{
    return Carbon::parse($date)->age;
}

function format_date($date, $format)
{
    $date = date_create($date);

    return date_format($date, $format);
}

function now($format = 'Y-m-d')
{
    return date($format);
}
