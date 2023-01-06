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

        $style = new SymfonyStyle($input, $output);

        $jobs = DB::table('jobs')
            ->where('date_reserve', '<=', time())
            ->get();

        foreach ($jobs as $job) {
            $payload = json_decode($job->payload);

            $class = $payload->job;
            $params = $payload->params;

            try {
                $class = new $class($params);
                $class->handle();

                $style->success($payload->job);

            } catch (Error $exception) {
                DB::table('failed_jobs')
                    ->insert([
                        'queue' => $job->queue,
                        'payload' => $job->payload,
                        'exception' => json_encode($exception)
                    ]);

                $style->error($payload->job);
            }
        }

        DB::table('jobs')
            ->delete();

        return Command::SUCCESS;
    }
}
