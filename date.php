<?php

/**
 * Return age of date given.
 *
 * @param  string $date
 * @return string
 */
function age($date)
{
    return Carbon\Carbon::parse($date)->age;
}

/**
 * Create an instance of date and format.
 *
 * @param  string $date
 * @param  string $format
 * @return string
 */
function format_date($date, $format)
{
    $date = date_create($date);
    return date_format($date, $format);
}

/**
 * Return current date with format given.
 *
 * @param  string $format
 * @return string
 */
function now($format = 'Y-m-d')
{
    return date($format);
}
