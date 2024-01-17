<?php

use App\Excel\Excel;
use App\Models\Language;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Number;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory as Validation;
use Spatie\Dns\Dns;
use Spatie\Image\Image;
use Spatie\Mjml\Mjml;
use Spatie\OpeningHours\OpeningHours;
use Spatie\PdfToImage\Pdf;

function abort($code = 404)
{
    http_response_code($code);

    if (ajax()) {
        view('http:' . $code);
    } else {
        return json(['status' => $code]);
    }

    exit();
}

function abort_if($condition, $code)
{
    if ($condition) {
        abort($code);
    }
}

function abort_unless($condition, $code)
{
    if (! $condition) {
        abort($code);
    }
}

function app_path($path)
{
    if (isset($_SERVER['DOCUMENT_ROOT'])) {
        return $_SERVER['DOCUMENT_ROOT'] . '/app/';
    }

    return '/app/';
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

function base_path()
{
    if (! isset($_SERVER['DOCUMENT_ROOT'])) {
        return $_SERVER['DOCUMENT_ROOT'] . '/';
    }

    return '/';
}

function bing()
{
    return new BingAI();
}

function can($permission)
{
    return auth()->can($permission);
}

function carbon()
{
    return new Carbon;
}

function cashConverter()
{
    return new CashConverter();
}

function cookie($key, $value, $lifetime)
{
    setcookie($key, $value, time() + $lifetime);
}

function currentRoute()
{
    return $_SERVER['REQUEST_URI'];
}

function database_path()
{
    if (! isset($_SERVER['DOCUMENT_ROOT'])) {
        return $_SERVER['DOCUMENT_ROOT'] . '/database/';
    }

    return '/database/';
}

function dispatch($job)
{
    return new Job($job);
}

function dispatch_if($condition, $job)
{
    if ($condition) {
        return new Job($job);
    }
}

function dispatch_unless($condition, $job)
{
    if (! $condition) {
        return new Job($job);
    }
}

function dns($url)
{
    if (! class_exists('Spatie\Dns\Dns')) {
        throw new Exception('Please execute `composer require spatie/dns`');
    }

    $dns = new Dns();
    return $dns->getRecords($url);
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

function image()
{
    if (! class_exists('Spatie\Image\Image')) {
        throw new Exception('Please execute `spatie/image`');
    }

    return new Image();
}

function info($text)
{
    echo "\033[32m$text\033[0m";
    echo "\n";
}

function health()
{
    return new Health();
}

function http()
{
    if (! class_exists('Illuminate\Http\Client\Factory')) {
        throw new Exception('Please execute `guzzlehttp/guzzle`');
    }

    return new HttpClient;
}

function lang($key)
{
    if (config('translate') == 'database') {
        $db = Language::where('language', $_ENV['language'])
            ->where('key', $key)
            ->first();

        if ($db) {
            return $db->value;
        }

        return $key;

    } else {
        try {
            $array = explode('.', $key);

            $file = $array[0];
            $key = $array[1];

            return $_ENV['translate'][$file][$key];
        } catch (Exception $exception) {
            return $key;
        }
    }
}

function logs()
{
    return new class
    {
        use Logs;
    };
}

function mjml($mjml)
{
    if (! class_exists('Spatie\Mjml\Mjml')) {
        throw new Exception('Please execute `composer require spatie/mjml-php && npm mjml`');
    }

    return Mjml::new();
}

function number()
{
    return new Number();
}

function openai()
{
    return new OpenAIBasePHP();
}

function openingHours()
{
    return new OpeningHours();
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

function report_if($condition, $message)
{
    if ($condition) {
        report($message);
    }
}

function report_unless($condition, $message)
{
    if (! $condition) {
        report($message);
    }
}

function resource_path()
{
    if (! isset($_SERVER['DOCUMENT_ROOT'])) {
        return $_SERVER['DOCUMENT_ROOT'] . '/resources/';
    }

    return '/resources/';
}

function response()
{
    return new Response();
}

function pdf($object)
{
    return $object;
}

function phpsessid()
{
    return $_COOKIE['PHPSESSID'];
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

function os()
{
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
        return 'Android';
    }

    if (strpos($_SERVER['HTTP_USER_AGENT'], 'iOS')) {
        return 'iOS';
    }

    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Linux')) {
        return 'Linux';
    }

    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Mac OS')) {
        return 'Mac OS';
    }

    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Windows')) {
        return 'Windows';
    }
}

function pdfToImage($pathToPdf)
{
    if (! class_exists('Spatie\PdfToImage\Pdf')) {
        throw new Exception('Please execute `composer require spatie/pdf-to-image`');
    }
    
    return new Pdf($pathToPdf);
}

function ssh()
{
    return new SSH();
}

function storage($adapter = 'local')
{
    return new Storage($adapter);
}

function strposToArray($needle, $haystack)
{
    $i = 0;

    foreach ($haystack as $item) {
        if (strpos($item, $needle) !== false) {
            return $i;
        }

        $i++;
    }

    return false;
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
