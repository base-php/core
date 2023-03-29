<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class MigrateStatus extends Command
{
    protected static $defaultName = 'migrate:status';

    protected static $defaultDescription = 'Muestra el estado de cada migración';

    public function configure()
    {
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'Conexión de base de datos a utilizar', 'default');
        $this->addOption('path', null, InputOption::VALUE_REQUIRED, 'Ruta al archivo de migración que se ejecutará');
    }

    protected function execute($input, $output)
    {
        $style = new SymfonyStyle($input, $output);

        $connection = $input->getOption('database') ?? 'default';
        $path = $input->getOption('path');

        foreach (scandir('database') as $item) {
            if (! is_dir($item)) {
                $class = require 'database/' . $item;

                if ($class->connection != $connection) {
                    return;
                }

                if ($path && $path != 'database/' . $item) {
                    return;
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
