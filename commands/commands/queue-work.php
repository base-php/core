<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class QueueWork extends Command
{
    protected static $defaultName = 'queue:work';

    protected static $defaultDescription = 'Comienza a procesar trabajos en la cola';

    protected function execute($input, $output)
    {
        include 'vendor/base-php/core/database/database.php';

        $jobs = DB::table('jobs')
            ->where('date_reserve', '<=', time())
            ->get();

        foreach ($jobs as $job) {
            $payload = json_decode($job->payload);

            $class = $payload->job;
            $params = $payload->params;

            $class = new $class($params);
            $class->handle();
        }

        return Command::SUCCESS;
    }
}
