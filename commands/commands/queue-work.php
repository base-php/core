<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueueWork extends Command
{
    protected static $defaultName = 'queue:work';

    protected static $defaultDescription = 'Comienza a procesar trabajos en la cola';

    public function configure()
    {
        $this->addArgument('queue', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        include 'vendor/base-php/core/database/database.php';

        $schema = $capsule->getConnection('default')->getSchemaBuilder();

        $style = new SymfonyStyle($input, $output);

        $queue = $input->getArgument('name') ?? 'default';

        $jobs = DB::table('jobs')
            ->where('queue', $queue)
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

                if ($schema->hasTable('monitor')) {
                    $monitor = new Monitor();
                    $monitor->jobs(get_class($class), $queue, 'success', null);
                }
            } catch (Error $exception) {
                DB::table('failed_jobs')
                    ->insert([
                        'queue' => $job->queue,
                        'payload' => $job->payload,
                        'exception' => json_encode($exception),
                    ]);

                $style->error($payload->job);

                if ($schema->hasTable('monitor')) {
                    $monitor = new Monitor();
                    $monitor->jobs($class, $queue, 'error', $exception);
                }
            }
        }

        DB::table('jobs')
            ->delete();

        return Command::SUCCESS;
    }
}
