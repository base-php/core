<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class QueueFlush extends Command
{
    protected static $defaultName = 'queue:flush';

    protected static $defaultDescription = 'Borra todos los trabajos fallidos en cola';

    protected function execute($input, $output)
    {
        include 'vendor/base-php/core/database/database.php';

        DB::table('failed_jobs')
            ->delete();

        $style = new SymfonyStyle($input, $output);
        $style->success('Todos los trabajos fallidos fueron borrados.');

        return Command::SUCCESS;
    }
}
