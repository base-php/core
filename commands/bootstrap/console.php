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

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(ConsoleEvents::COMMAND, function ($event) {
            $schema = $capsule->getConnection('default')->getSchemaBuilder();

            if ($schema->exists('monitor')) {
                $monitor = new Monitor();
                $monitor->command($event->getInput());
            }
        });

        $application->setDispatcher($dispatcher);

        $application->run();
    }
}
