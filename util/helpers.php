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
    view($code);
    return die();
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
            $_SESSION['user'] = $user->id;
        }
    }

    if ($id == '') {
        if (isset($_SESSION['id'])) {
            if (isset($_SESSION['basephp-user'])) {
                $user = $_SESSION['basephp-user'];
            } else {
                $user = User::find($_SESSION['id']);
                $_SESSION['basephp-user'] = $user;
            }

            return $user;
        }

        return false;
    }
}

function authorize($condition)
{
    if (!$condition) {
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
    $config = require('app/config.php');
    $locale = $config['language'] . '_' . strtoupper($config['language']);
    return Faker::create($locale);
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
    return DB::table('logs');
}

function redirect($to)
{
    $redirect = new Redirect;
    return $redirect->redirect($to);
}

function response()
{
    return new Response();
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

function session($key = '', $value = '')
{
    $session = new Session;

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
    include __dir__ . '/../database/database.php';

    $files      = new Filesystem();
    $loader     = new FileLoader($files, '');
    $translator = new Translator($loader, $_ENV['language']);
    $factory    = new Validation($translator);

    $verifier = new DatabasePresenceVerifier($capsule->getDatabaseManager());

    $factory->setPresenceVerifier($verifier);

    $validation = $factory->make($data, $rules, $messages);

    if ($validation->errors()->all()) {
        $errors = $validation->errors()->all();

        $_SESSION['basephp-flash']['errors'] = $errors;
        $_SESSION['basephp-flash']['inputs']  = $data;

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
