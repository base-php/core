<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class QueueTable extends Command
{
    protected static $defaultName = 'queue:table';

    protected static $defaultDescription = 'Crear migraciones para las tablas de colas';

    protected function execute($input, $output)
    {
        copy('vendor/base-php/core/jobs/migrations/1661861127_jobs.php', 'database/1661861127_jobs.php');
        copy('vendor/base-php/core/jobs/migrations/1661862061_failed_jobs.php', 'database/1661862061_failed_jobs.php');

        $style = new SymfonyStyle($input, $output);
        $style->success("Migraciones creadas satisfactoriamente.");

        return Command::SUCCESS;
    }
}
