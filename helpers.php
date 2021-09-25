<?php

/**
 * Quick access to Storage class.
 *
 * @param string $adapter
 * @return Storage
*/
function storage(string $adapter = 'local'): Storage
{
    return new Storage($adapter);
}

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
 * 
 * @return Factory
 */
function http(): Factory
{
    return new Illuminate\Http\Client\Factory;
}

/**
 * Helper for redirection.
 * 
 * @param string $to
 * 
 * @return redirect
 */
function redirect(string $to): Redirect
{
    $redirect = new Redirect;
    $redirect->to = $to;
    return $redirect;
}

/**
 * Helper for Email class.
 *
 * @return void
 */
function email(string $to, object $object): void
{
    $object->send($to);
}

/**
 * Helper for Excel class.
 * 
 * @param string $filename
 * @param object $object
 *
 * @return void|array
 */
function excel(string $filename, $object)
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
 * @return void
 */
function facebook()
{
    return Facebook::init()->url('https://localhost:8080/login/facebook');
}

/**
 * Helper for Google login class.
 *
 * @return void
 */
function google()
{
    return Google::init()->url();
}

/**
 * Helper for PDF class.
 *
 * @param object $object
 * 
 * @return PDF
 */
function pdf($object): PDF
{
    return $object;
}

/**
 * Helper for Stripe class.
 *
 * @return Stripe
 */
function stripe(): Stripe
{
    return Stripe::init();
}
