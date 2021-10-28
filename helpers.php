<?php

use App\Excel\Excel;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Http\Client\Factory;

class DB extends Manager
{

}

function email($to, $object)
{
    $object->send($to);
}

function excel($filename, $object)
{
    if ($object != '') {
        $object->store($filename);
    } else {
        $excel = new Excel();
        $excel->read($filename);
    }
}

function facebook()
{
    return Facebook::init()->url('https://localhost:8080/login/facebook');
}

function google()
{
    return Google::init()->url();
}

function http()
{
    return new Factory;
}

function redirect($to)
{
    $redirect = new Redirect;
    $redirect->to = $to;
    return $redirect;
}

function pdf($object)
{
    return $object;
}

function storage($adapter = 'local')
{
    return new Storage($adapter);
}

function view($view, $data = [])
{
    $class = new View();
    return $class->render($view, $data);
}
