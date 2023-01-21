<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class MigrateRefresh extends Command
{
    protected static $defaultName = 'migrate:refresh';

    protected static $defaultDescription = 'Restablece y vuelve a ejecutar todas las migraciones';

    protected function execute($input, $output)
    {
        include 'vendor/base-php/core/database/database.php';

        $style = new SymfonyStyle($input, $output);

        foreach (scandir('database') as $migration) {
            if (is_dir($migration)) {
                continue;
            }

            try {
                $class = require 'database/'.$migration;
                $class->down();

                $name = str_replace('.php', '', $migration);

                DB::connection($class->connection)
                    ->table('migrations')
                    ->where('name', $name)
                    ->delete();

                $style->warning($name);

                $class->up();

                DB::connection($class->connection)
                    ->table('migrations')
                    ->insert([
                        'name' => $name,
                        'batch' => 1,
                    ]);

                $style->success($name);
            } catch (Exception $exception) {
                $style->error($exception->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
