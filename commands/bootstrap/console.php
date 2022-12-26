<?php

use Symfony\Component\Console\Application;

class Console
{
    public static function run()
    {
        $config = require 'app/config.php';

        $application = new Application('Base PHP ' . $config['version'] . ' by Nisa Delgado');

        $application->add(new About());
        $application->add(new AuthInstall());
        $application->add(new DBBackup());
        $application->add(new Docs());
        $application->add(new Env());
        $application->add(new Inspire());
        $application->add(new LogsTable());
        $application->add(new MakeCommand());
        $application->add(new MakeController());
        $application->add(new MakeDatabase());
        $application->add(new MakeExcel());
        $application->add(new MakeJob());
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
        $application->add(new ModelShow());
        $application->add(new NotificationsTable());
        $application->add(new PermissionsCreatePermission());
        $application->add(new PermissionsCreateRole());
        $application->add(new PermissionsTable());
        $application->add(new QueueClear());
        $application->add(new QueueTable());
        $application->add(new QueueWork());
        $application->add(new Server());
        $application->add(new Shell());
        $application->add(new Test());
        $application->add(new TokensTable());
        $application->add(new ViewClear());

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
