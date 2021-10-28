<?php

/**
 * Return age of date given.
 *
 * @param  string $date
 * @return string
 */
function age(string $date): string
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
function format_date(string $date, string $format): string
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
function now(string $format = 'Y-m-d'): string
{
    return date($format);
}
