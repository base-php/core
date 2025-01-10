<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'migrate:status', description: 'Muestra el estado de cada migración')]
class MigrateStatus extends Command
{
    public function configure()
    {
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'Conexión de base de datos a utilizar', 'default');
        $this->addOption('path', null, InputOption::VALUE_REQUIRED, 'Ruta al archivo de migración que se ejecutará');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $connection = $input->getOption('database') ?? 'default';
        $path = $input->getOption('path');

        foreach (scandir('database') as $item) {
            if (! is_dir($item)) {
                if (pathinfo('database/' . $item)['extension'] == 'sqlite') {
                    continue;
                }

                $class = require 'database/' . $item;

                $class->connection = $class->connection ?? 'default';

                if ($class->connection != $connection) {
                    return Command::SUCCESS;
                }

                if ($path && $path != 'database/' . $item) {
                    return Command::SUCCESS;
                }

                $name = str_replace('.php', '', $item);

                $exists = DB::connection($class->connection)
                    ->table('migrations')
                    ->where('name', $name)
                    ->get();

                if ($exists->count()) {
                    $style->success($name . ' ejecutada');
                } else {
                    $style->warning($name . ' pendiente');
                }
            }
        }

        return Command::SUCCESS;
    }
}
