<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class MigrateReset extends Command
{
    protected static $defaultName = 'migrate:reset';

    protected static $defaultDescription = 'Revertir todas las migraciones';

    public function configure()
    {
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'Conexión de base de datos a utilizar', 'default');
    }

    protected function execute($input, $output)
    {
        require 'vendor/base-php/core/database/database.php';

        $config = require 'app/config.php';
        $connection = $input->getOption('database');

        $migrations = DB::connection($connection)
            ->table('migrations')
            ->get();

        $style = new SymfonyStyle($input, $output);

        foreach ($migrations as $migration) {
            try {
                $class = require 'database/' . $migration->name . '.php';
                $class->down();

                DB::connection($connection)
                    ->table('migrations')
                    ->where('id', $migration->id)
                    ->delete();

                $style->warning($migration->name);
            }
            catch (Exception $exception) {
                $style->error($exception->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
