<?php

use App\Excel\Excel;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory as Validation;

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
    return new HttpClient;
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

function qr($data)
{
    $qr = new QR;
    $qr->data($data);
    return $qr->generate();
}

function storage($adapter = 'local')
{
    return new Storage($adapter);
}

function validation($data, $rules, $messages, $connection = 'default')
{
    include 'database.php';

    $files      = new Filesystem();
    $loader     = new FileLoader($files, '');
    $translator = new Translator($loader, 'es');
    $factory    = new Validation($translator);

    $verifier = new DatabasePresenceVerifier($capsule->getDatabaseManager($connection));

    $factory->setPresenceVerifier($verifier);

    $validation = $factory->make(request(), $rules(), $messages());

    if ($validation->errors()->all()) {
        $errors = $validation->errors()->all();

        $_SESSION['flashmessages']['errors'] = $errors;
        $_SESSION['flashmessages']['input']  = request();

        redirect($_SERVER['HTTP_REFERER']);
        return exit;
    }
}

function view($view, $data = [])
{
    $class = new View();
    return $class->render($view, $data);
}
