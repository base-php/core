<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'Revertir todas las migraciones', description: 'migrate:reset')]
class MigrateReset extends Command
{
    public function configure()
    {
        $this->addOption('database', 'default', InputOption::VALUE_NONE, 'Conexión de base de datos a utilizar');
        $this->addOption('path', null, InputOption::VALUE_REQUIRED, 'Ruta al archivo de migración que se ejecutará');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        require 'vendor/base-php/core/database/database.php';

        $config = require 'app/config.php';
        $connection = $input->getOption('database') ?? 'default';

        $migrations = DB::connection($connection)
            ->table('migrations')
            ->get();

        $migrations = $input->getOption('path') ?? $migrations;

        $style = new SymfonyStyle($input, $output);

        foreach ($migrations as $migration) {
            try {
                $require = $input->getOption('path') ? $migration : 'database/' . $migration;
                
                $class = require $require;
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
