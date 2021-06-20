<?php

/**
 * Helper for Email class.
 *
 * @return Email
 */
function email()
{
    $email = new Email;
    return $email->init();
}

/**
 * Helper for Excel class.
 * 
 * @param string $filename
 * @param object $object
 *
 * @return Excel
 */
function excel($filename, $object = '')
{
    if ($object != '') {
        $object->store($filename);
    } else {
        $excel = new App\Excel\Excel();
        return $excel->read($filename);
    }
}

/**
 * Helper for Facebook login class.
 *
 * @return Facebook
 */
function facebook()
{
    return Facebook::init();
}

/**
 * Helper for File class.
 *
 * @return File
 */
function files()
{
    return File::init();
}

/**
 * Helper for Google login class.
 *
 * @return Google
 */
function google()
{
    return Google::init();
}

/**
 * Helper for PDF class.
 *
 * @return PDF
 */
function pdf()
{
    $pdf = new PDF;
    return $pdf;
}

/**
 * Helper for Stripe class.
 *
 * @return Stripe
 */
function stripe()
{
    return Stripe::init();
}
