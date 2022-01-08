<?php

use App\Excel\Excel;
use Faker\Factory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory as Validation;

function arr()
{
    return new Arr;
}

function email($to, $object)
{
    $object->send($to);
}

function excel($filename, $object = '')
{
    if ($object != '') {
        $object->save($filename);
    } else {
        $excel = new Excel();
        return $excel->read($filename);
    }
}

function facebook()
{
    return Facebook::init();
}

function faker()
{
    return Faker\Factory::create();
}

function google()
{
    return Google::init();
}

function info($text)
{
    echo "\033[32m$text\033[0m";
    echo "\n";
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

function str()
{
    return new Str;
}

function validation($data, $rules, $messages, $redirect)
{
    include 'database.php';

    $files      = new Filesystem();
    $loader     = new FileLoader($files, '');
    $translator = new Translator($loader, 'es');
    $factory    = new Validation($translator);

    $verifier = new DatabasePresenceVerifier($capsule->getDatabaseManager());

    $factory->setPresenceVerifier($verifier);

    $validation = $factory->make($data, $rules, $messages);

    if ($validation->errors()->all()) {
        $errors = $validation->errors()->all();

        $_SESSION['flashmessages']['errors'] = $errors;
        $_SESSION['flashmessages']['input']  = $data;

        $redirect = ($redirect) ? $redirect : $_SERVER['HTTP_REFERER'];

        redirect($redirect);
        return exit;
    }
}

function view($view, $data = [])
{
    $class = new View();
    return $class->render($view, $data);
}
