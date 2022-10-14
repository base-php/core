<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class LogsTable extends Command
{
    protected static $defaultName = 'logs:table';

    protected static $defaultDescription = 'Crear una migración para la tabla de logs';

    protected function execute($input, $output)
    {
        copy('vendor/base-php/core/logs/migrations/1665063738_logs.php', 'database/1665063738_logs.php');

        $style = new SymfonyStyle($input, $output);
        $style->success("Migración creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
