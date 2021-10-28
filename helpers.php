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
 * @return void|array
 */
function excel($filename, $object)
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
 * Quick access to the HTTP class.
 *
 * 
 * @return Factory
 */
function http()
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
function redirect($to)
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
function pdf($object)
{
    return $object;
}

/**
 * Quick access to Storage class.
 *
 * @param string $adapter
 * @return Storage
*/
function storage($adapter = 'local')
{
    return new Storage($adapter);
}

/**
 * Quick access to View class.
 *
 * @param  string  $view
 * @param  array   $data
 * @return void
 */
function view($view, $data = [])
{
    $class = new View();
    return $class->render($view, $data);
}
