<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MonitorTable extends Command
{
    protected static $defaultName = 'monitor:table';

    protected static $defaultDescription = 'Crear migración para tabla de monitor';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        copy('vendor/base-php/core/packages/monitor/migrations/monitor.php', 'database/' . date('Y_m_d_His').'_monitor.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Migraciones creadas satisfactoriamente.');

        return Command::SUCCESS;
    }
}
