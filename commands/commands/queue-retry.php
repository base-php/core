<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class QueueRetry extends Command
{
    protected static $defaultName = 'queue:retry';

    protected static $defaultDescription = 'Reintentar trabajos fallidos en cola';

    protected function execute($input, $output)
    {
        include 'vendor/base-php/core/database/database.php';

        $faileds = DB::table('failed_jobs')->get();

        foreach ($faileds as $failed) {
            DB::table('jobs')->insert([
                'queue' => $failed->queue,
                'payload' => $failed->payload,
                'attemps' => 1,
                'date_reserve' => time()
            ]);
        }

        $count = $faileds->count();

        $style = new SymfonyStyle($input, $output);
        $style->success("$count jobs requeued.");

        DB::table('failed_jobs')->delete();

        return Command::SUCCESS;
    }
}
