<?php

/**
 * Quick access to the DB class.
 * 
 * @return DB
 */
class DB extends Illuminate\Database\Capsule\Manager
{

}

/**
 * Quick access to the HTTP class.
 * 
 * @param string $to
 * 
 * @return HTTP
 */
function http()
{
    return new HTTP();
}

/**
 * Helper for redirection.
 * 
 * @param string $to
 * 
 * @return redirect
 */
function redirect($to)
{
    $redirect = new Redirect;
    $redirect->to = $to;
    return $redirect;
}

/**
 * Helper for Email class.
 *
 * @return Email
 */
function email($to, $object)
{
    $object->send($to);
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
 * @param object $object
 * 
 * @return PDF
 */
function pdf($object)
{
    return $object;
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
