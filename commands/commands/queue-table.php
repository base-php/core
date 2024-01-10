<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueueTable extends Command
{
    protected static $defaultName = 'queue:table';

    protected static $defaultDescription = 'Crear migraciones para las tablas de colas';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        copy('vendor/base-php/core/jobs/migrations/jobs.php', 'database/' . date('Y_m_d_His').'_jobs.php');
        copy('vendor/base-php/core/jobs/migrations/failed_jobs.php', 'database/' . date('Y_m_d_His').'_failed_jobs.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Migraciones creadas satisfactoriamente.');

        return Command::SUCCESS;
    }
}
