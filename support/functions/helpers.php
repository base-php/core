<?php

use App\Excel\Excel;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Support\Arr;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory as Validation;

function abort($code = 404)
{
    http_response_code($code);
    view('http:' . $code);

    return exit();
}

function arr()
{
    return new Arr;
}

function auth($id = '')
{
    if ($id != '') {
        $user = User::find($id);

        if ($user) {
            session('user', $user->id);
        }
    }

    if ($id == '') {
        if (session('id')) {
            if (session('basephp-user')) {
                $user = session('basephp-user');
            } else {
                $user = User::find(session('id'));
                session('basephp-user', $user);
            }

            return $user;
        }

        return false;
    }
}

function authorize($condition)
{
    if (! $condition) {
        return abort(401);
    }
}

function backup($connection = '')
{
    return new Backup($connection);
}

function can($permission)
{
    return auth()->can($permission);
}

function carbon()
{
    return new Carbon;
}

function dispatch($job)
{
    return new Job($job);
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
    $config = require 'app/config.php';
    $locale = $config['language'].'_'.strtoupper($config['language']);

    return Faker::create($locale);
}

function feature()
{
    return new Feature;
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
    if (! class_exists('Illuminate\Http\Client\Factory')) {
        throw new Exception("Please execute 'composer require guzzlehttp/guzzle' in console.");
    }

    return new HttpClient;
}

function lang($key)
{
    try {
        $array = explode('.', $key);

        $file = $array[0];
        $key = $array[1];

        return $_ENV['translate'][$file][$key];
    } catch (Exception $exception) {
        return $key;
    }
}

function logs()
{
    return new class
    {
        use Logs;
    };
}

function openai()
{
    return new OpenAIBasePHP;
}

function redirect($to)
{
    $redirect = new Redirect;

    return $redirect->redirect($to);
}

function report($message)
{
    throw new Exception($message);
}

function response()
{
    return new Response();
}

function pdf($object)
{
    return $object;
}

function process()
{
    return new Process;
}

function qr($data)
{
    $qr = new QR;
    $qr->data($data);

    return $qr->generate();
}

function session($key = '', $value = '')
{
    $session = new Session;

    if (config('session_driver') == 'database') {
        $session = new DatabaseBasedSession;
    }

    if ($key && $value) {
        return $session->set($key, $value);
    }

    if ($key) {
        return $session->get($key);
    }

    return $session;
}

function storage($adapter = 'local')
{
    return new Storage($adapter);
}

function two_fa()
{
    if (post()) {
        $two_fa = new TwoFA;

        return $two_fa->verify();
    }

    return new TwoFA;
}

function validation($data, $rules, $messages, $redirect)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/vendor/base-php/core/database/database.php';

    $files = new Filesystem();
    $loader = new FileLoader($files, '');
    $translator = new Translator($loader, $_ENV['language']);
    $factory = new Validation($translator);

    $verifier = new DatabasePresenceVerifier($capsule->getDatabaseManager());

    $factory->setPresenceVerifier($verifier);

    $validation = $factory->make($data, $rules, $messages);

    if ($validation->errors()->all()) {
        $errors = $validation->errors()->all();

        session('basephp-flash.errors', $errors);
        session('basephp-flash.inputs', $data);

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
