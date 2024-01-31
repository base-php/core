<?php

use Illuminate\Container\Container;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\RoutingServiceProvider;
use Illuminate\Support\Facades\Facade;
use Netflie\Componentes\Componentes;
use Spatie\Ignition\Ignition;

class App
{
    public static function run()
    {
        $time = time();

        // General settings

        $session_save_path = config('session_save_path') ?? $_SERVER['DOCUMENT_ROOT'] . '/vendor/base-php/core/tmp';
        $session_lifetime = config('session_lifetime') ?? 1440;
        $memory_limit = config('memory_limit') ?? -1;
        $time_limit = config('time_limit') ?? 30;
        $error_log = config('error_log') ?? 'vendor/base-php/core/tmp/error.log';

        ini_set('memory_limit', $memory_limit);
        ini_set('error_log', $error_log);

        set_time_limit($time_limit);

        session_set_cookie_params($session_lifetime, '/');
        session_save_path($session_save_path);

        session_start();

        header('Access-Control-Allow-Origin: *');

        // Config

        $config = require 'app/config.php';

        foreach ($config as $key => $value) {
            $_ENV[$key] = $value;
        }

        $_ENV['view'] = false;

        Lang::set();

        date_default_timezone_set($_ENV['timezone']);

        include __DIR__.'/../database/database.php';

        // Errors

        if ($_ENV['errors'] == false) {
            error_reporting(0);
        } else {
            Ignition::make()->register();
        }

        if ($_ENV['maintenance']) {
            return abort(503);
        }

        if (isset($_GET['actingAs'])) {
            session('id', $_GET['actingAs']);
        }

        if (isset($_GET['withSession'])) {
            foreach ($_GET['withSession'] as $key => $value) {
                session($key, $value);
            }
        }

        if (isset($_GET['withHeaders'])) {
            foreach ($_GET['withHeaders'] as $key => $value) {
                header($key . ': ' . $value);
            }
        }

        if (isset($_GET['ddSessions'])) {
            dd(session()->all());
        }

        if (isset($_GET['ddHeaders'])) {
            dd(get_headers($_SERVER['REQUEST_URI']));
        }

        // Container

        $app = new Container;
        Facade::setFacadeApplication($app);
        $app['app'] = $app;
        $app['env'] = 'production';
        with(new EventServiceProvider($app))->register();
        with(new RoutingServiceProvider($app))->register();

        // Router

        $route = $app['router'];
        include 'app/routes.php';

        $route->fallback(function () {
            http_response_code(404);
            
            if (file_exists($_SERVER['DOCUMENT_ROOT'].'/resources/views/errors/404.blade.php')) {
                return view('errors/404');
            } else {
                $viewPath = realpath($_SERVER['DOCUMENT_ROOT'].'/vendor/base-php/core/http/views');
                $componentes = Componentes::create($viewPath);

                $view = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/vendor/base-php/core/http/views/404.blade.php');
                echo $componentes->render($view, []);
            }
        });

        if (file_exists('app/helpers.php')) {
            include 'app/helpers.php';
        }

        // Response

        $request = Request::createFromGlobals();
        $response = $app['router']->dispatch($request);
        $response->send();

        // Monitor

        $monitor = new Monitor();

        $schema = $capsule->getConnection('default')->getSchemaBuilder();

        if ($schema->hasTable('monitor') && !strpos(currentRoute(), 'monitor')) {
            $duration = time() - $time;
            $monitor->request($duration);

            $logs = DB::getQueryLog();
            $monitor->database($logs);
        }

        foreach (session()->all() as $key => $value) {
            if (strpos($key, 'basephp-user') !== false) {
                session()->delete($key);
            }

            if (strpos($key, 'basephp-flash') !== false) {
                session()->delete($key);
            }

            if (strpos($key, 'basephp-permissions') !== false) {
                session()->delete($key);
            }
        }
    }
}
