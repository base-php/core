<?php

/**
 * Return current date with format given.
 *
 * @param  string $format
 * @return date
 */
function now($format = 'Y-m-d')
{
    return date($format);
}

/**
 * Create an instance of date and format.
 *
 * @param  string $date
 * @param  string $format
 * @return date_format
 */
function format_date($date, $format)
{
    $date = date_create($date);
    return date_format($date, $format);
}

/**
 * Return age of date given.
 *
 * @param  string $date
 * @return Carbon\Carbon
 */
function age($date)
{
	return Carbon\Carbon::parse($date)->age;
}
