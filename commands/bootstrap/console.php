<?php

use NunoMaduro\Collision\Provider as Collision;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Console
{
    public static function run()
    {
        (new Collision)->register();

        $config = require 'app/config.php';

        $memory_limit = config('memory_limit') ?? -1;
        $time_limit = config('time_limit') ?? 30;
        $error_log = config('error_log') ?? 'vendor/base-php/core/tmp/error.log';

        ini_set('memory_limit', $memory_limit);
        ini_set('error_log', $error_log);
        set_time_limit($time_limit);

        foreach ($config as $key => $value) {
            $_ENV[$key] = $value;
        }

        Lang::set();

        date_default_timezone_set($_ENV['timezone']);

        $application = new Application('Base PHP ' . $config['version'] . ' por Nisa Delgado');

        foreach (scandir('vendor/base-php/core/commands/commands') as $class) {
            if (! is_dir($class)) {
                $class = str($class)
                    ->studly()
                    ->replace('.php', '')
                    ->toString();

                if ($class == 'Health') {
                    $class = 'HealthCmd';
                }

                $application->add(new $class());
            }
        }

        if (file_exists('app/Commands')) {
            foreach (scandir('app/Commands') as $command) {
                if (! is_dir($command)) {
                    $class = 'App\Commands\\' . str_replace('.php', '', $command);

                    $application->add(new $class());
                }
            }
        }

        $i = array_search('default1', array_column($config['database'], 'name'));

        $config['database'][$i]['host'] = $config['database'][$i]['host'] ?? '';
            
        if ($config['database'][$i]['host'] != 'mysql' && $config['database'][$i]['host'] != 'pgsql') {
            $dispatcher = new EventDispatcher();
            $dispatcher->addListener(ConsoleEvents::COMMAND, function ($event) use ($config) {
                if ($config['database'][0]['driver'] == 'sqlite' && ! file_exists($config['database'][0]['database'] . '.sqlite')) {
                    return;
                }

                include 'vendor/base-php/core/database/database.php';
                
                $schema = $capsule->getConnection('default')->getSchemaBuilder();

                if ($schema->hasTable('monitor')) {
                    $monitor = new Monitor();
                    $monitor->command($event->getInput());

                    $logs = DB::getQueryLog();
                    $monitor->database($logs);
                }
            });

            $application->setDispatcher($dispatcher);
        }

        $application->run();
    }
}
