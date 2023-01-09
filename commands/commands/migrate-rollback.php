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
        $this->addOption('step', null, InputOption::OPTIONAL, 'Número de migraciones a revertir', 1);
        $this->addOption('database', null, InputOption::OPTIONAL, 'Conexión de base de datos a utilizar', 'default');
    }

    protected function execute($input, $output)
    {
        $config = require 'app/config.php';

        $step = $input->getOption('step');
        $connection = $input->getOption('database');

        $batch = DB::connection($connection)
            ->table('migrations')
            ->max('batch');

        $migrations = DB::connection($connection)
            ->table('migrations')
            ->where('batch', $batch)
            ->get();

        if ($step) {
            $migrations = DB::connection($connection)
                ->table('migrations')
                ->orderByDesc('batch')
                ->limit($step)
                ->get();
        }

        foreach ($migrations as $migration) {
            try {
                $class = require 'database/' . $migration->name . '.php';
                $class->down();
                
                $migration->delete();

                $this->success($migration->name . ' revertida.');
            }
            catch (Exception $exception) {
                $this->error($exception->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
