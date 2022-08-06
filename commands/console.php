<?php

use Symfony\Component\Console\Application;

class Console
{
    public static function run()
    {
        $config = require 'app/config.php';

        $application = new Application('Base PHP ' . $config['version'] . ' by Nisa Delgado');

        $application->add(new About());
        $application->add(new ClearCache());
        $application->add(new Inspire());
        $application->add(new MakeBackup());
        $application->add(new MakeCommand());
        $application->add(new MakeController());
        $application->add(new MakeDatabase());
        $application->add(new MakeExcel());
        $application->add(new MakeMail());
        $application->add(new MakeMiddleware());
        $application->add(new MakeMigration());
        $application->add(new MakeModel());
        $application->add(new MakeNotification());
        $application->add(new MakePdf());
        $application->add(new MakeResource());
        $application->add(new MakeRule());
        $application->add(new MakeTest());
        $application->add(new MakeValidation());
        $application->add(new Migrate());
        $application->add(new Test());
        $application->add(new Server());
        $application->add(new Shell());

        if (file_exists('app/Commands')) {
            foreach (scandir('app/Commands') as $command) {
                if (!is_dir($command)) {
                    $class = 'App\Commands\\' . str_replace('.php', '', $command);

                    $application->add(new $class());
                }
            }
        }

        $application->run();
    }
}
