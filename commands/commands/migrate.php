<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Migrate extends Command
{
    protected static $defaultName = 'migrate';

    protected static $defaultDescription = 'Ejecuta las migraciones de base de datos';

    protected function execute($input, $output)
    {
        $style = new SymfonyStyle($input, $output);

        foreach (scandir('database') as $item) {
            if (!is_dir($item)) {
                $name = str_replace('.php', '', $item);

                $class = require("database/$item");

                $exists = DB::connection($class->connection)
                    ->table('migrations')
                    ->where('name', $name)
                    ->get();

                if ($exists->count()) {
                    continue;
                }

                try {
                    $class->up();

                    $batch = DB::connection($class->connection)
                        ->table('migrations')
                        ->max('batch');

                    $batch++;

                    DB::connection($class->connection)
                        ->table('migrations')
                        ->insert([
                            'name' => $name,
                            'batch' => $batch
                        ]);

                    $style->success("$item está ok.");
                }
                catch (Exception $exception) {
                    $style->error($exception->getMessage());
                }
            }
        }

        return Command::SUCCESS;
    }
}
