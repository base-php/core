<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'migrate:refresh', description: 'Restablece y vuelve a ejecutar todas las migraciones')]
class MigrateRefresh extends Command
{
    public function configure()
    {
        $this->addOption('database', 'default', InputOption::VALUE_NONE, 'Conexión de base de datos a utilizar');
        $this->addOption('path', null, InputOption::VALUE_REQUIRED, 'Ruta al archivo de migración que se ejecutará');
        $this->addOption('step', null, InputOption::VALUE_REQUIRED, 'El número de migraciones que se revertirán y volverán a ejecutar');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        include 'vendor/base-php/core/database/database.php';

        $style = new SymfonyStyle($input, $output);

        $database = $input->getOption('database');
        $migrations = $input->getOption('path') ?? scandir('database');

        if ($input->getOption('step')) {
            $migrations = DB::connection($database)
                ->table('migrations')
                ->orderByDesc('batch')
                ->limit($step)
                ->get();
        }

        foreach ($migrations as $migration) {
            if (is_dir($migration)) {
                continue;
            }

            if ($input->getOption('step')) {
                $migration = $migration->name . '.php';
            }

            try {
                $require = $input->getOption('path') ? $migration : 'database/' . $migration;

                if (pathinfo($require)['extension'] == 'sqlite') {
                    continue;
                }
                
                $class = require $require;
                $class->down();

                if ($database && $database != $class->connection) {
                    continue;
                }

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
