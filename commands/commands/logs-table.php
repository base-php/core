<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LogsTable extends Command
{
    protected static $defaultName = 'logs:table';

    protected static $defaultDescription = 'Crear una migración para la tabla de logs';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        copy('vendor/base-php/core/packages/logs/migrations/logs.php', 'database/' . date('Y_m_d_His') . '_logs.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Migración creada satisfactoriamente.');

        return Command::SUCCESS;
    }
}
