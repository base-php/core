<?php

use App\Excel\Excel;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Http\Client\Factory;

/**
 * Quick access to the DB class.
 * 
 * @return DB
 */
class DB extends Manager
{

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
function excel(string $filename, $object): void
{
    if ($object != '') {
        $object->store($filename);
    } else {
        $excel = new Excel();
        $excel->read($filename);
    }
}

/**
 * Helper for Facebook login class.
 *
 * @return void
 */
function facebook(): Facebook
{
    return Facebook::init()->url('https://localhost:8080/login/facebook');
}

/**
 * Helper for Google login class.
 *
 * @return void
 */
function google(): Google
{
    return Google::init()->url();
}

/**
 * Quick access to the HTTP class.
 *
 * 
 * @return Factory
 */
function http(): Factory
{
    return new Factory;
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
 * Helper for Stripe class.
 *
 * @return Stripe
 */
function stripe(): Stripe
{
    return Stripe::init();
}

/**
 * Quick access to View class.
 *
 * @param  string  $view
 * @param  array   $data
 * @return void
 */
function view(string $view, array $data = []): View
{
    $class = new View();
    return $class->render($view, $data);
}
