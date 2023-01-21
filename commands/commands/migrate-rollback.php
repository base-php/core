<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class MigrateRollback extends Command
{
    protected static $defaultName = 'migrate:rollback';

    protected static $defaultDescription = 'Revertir la última migración de la base de datos';

    public function configure()
    {
        $this->addOption('step', null, InputOption::VALUE_OPTIONAL, 'Número de migraciones a revertir', 1);
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'Conexión de base de datos a utilizar', 'default');
    }

    protected function execute($input, $output)
    {
        require 'vendor/base-php/core/database/database.php';

        $config = require 'app/config.php';

        $step = $input->getOption('step');
        $connection = $input->getOption('database');

        $batch = DB::connection($connection)
            ->table('migrations')
            ->max('batch');

        $migrations = DB::connection($connection)
            ->table('migrations')
            ->orderByDesc('batch')
            ->limit($step)
            ->get();

        $style = new SymfonyStyle($input, $output);

        foreach ($migrations as $migration) {
            try {
                $class = require 'database/'.$migration->name.'.php';
                $class->down();

                DB::connection($connection)
                    ->table('migrations')
                    ->where('id', $migration->id)
                    ->delete();

                $style->warning($migration->name);
            } catch (Exception $exception) {
                $style->error($exception->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
