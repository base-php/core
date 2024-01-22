<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'monitor:table', description: 'Crear migración para tabla de monitor')]
class MonitorTable extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        copy('vendor/base-php/core/packages/monitor/migrations/monitor.php', 'database/' . date('Y_m_d_His').'_monitor.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Migraciones creadas satisfactoriamente.');

        return Command::SUCCESS;
    }
}
