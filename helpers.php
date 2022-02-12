<?php

use App\Excel\Excel;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Support\Arr;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory as Validation;

function arr()
{
    return new Arr;
}

function backup($connection = '')
{
    return new Backup($connection);
}

function carbon()
{
    return new Carbon;
}

function email($to, $object)
{
    $object->send($to);
}

function encrypt($text)
{
    return md5($text);
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
    return Faker::create();
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

// guzzlehttp/guzzle
function http()
{
    return new HttpClient;
}

function redirect($to)
{
    $redirect = new Redirect;
    return $redirect->redirect($to);
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

function validation($data, $rules, $messages, $redirect)
{
    include 'database.php';

    $files      = new Filesystem();
    $loader     = new FileLoader($files, '');
    $translator = new Translator($loader, $_ENV['language']);
    $factory    = new Validation($translator);

    $verifier = new DatabasePresenceVerifier($capsule->getDatabaseManager());

    $factory->setPresenceVerifier($verifier);

    $validation = $factory->make($data, $rules, $messages);

    if ($validation->errors()->all()) {
        $errors = $validation->errors()->all();

        $_SESSION['flashmessages']['errors'] = $errors;
        $_SESSION['flashmessages']['inputs']  = $data;

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
