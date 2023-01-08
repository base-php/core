<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class QueueTable extends Command
{
    protected static $defaultName = 'queue:table';

    protected static $defaultDescription = 'Crear migraciones para las tablas de colas';

    protected function execute($input, $output)
    {
        copy('vendor/base-php/core/jobs/migrations/jobs.php', 'database/'.date('Y_m_d_His').'_jobs.php');
        copy('vendor/base-php/core/jobs/migrations/failed_jobs.php', 'database/'.date('Y_m_d_His').'_failed_jobs.php');

        $style = new SymfonyStyle($input, $output);
        $style->success("Migraciones creadas satisfactoriamente.");

        return Command::SUCCESS;
    }
}
