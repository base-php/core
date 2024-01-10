<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueueRetry extends Command
{
    protected static $defaultName = 'queue:retry';

    protected static $defaultDescription = 'Reintentar trabajos fallidos en cola';

    public function configure()
    {
        $this->addOption(
            'queue',
            null,
            InputOption::VALUE_OPTIONAL,
            'Reintenta los trabajos fallidos de una cola en específico',
            'default'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        include 'vendor/base-php/core/database/database.php';

        $queue = $input->getOption('queue');

        $faileds = DB::table('failed_jobs')
            ->where('queue', $queue)
            ->get();

        foreach ($faileds as $failed) {
            DB::table('jobs')->insert([
                'queue' => $failed->queue,
                'payload' => $failed->payload,
                'attemps' => 1,
                'date_reserve' => time(),
            ]);
        }

        $count = $faileds->count();

        $style = new SymfonyStyle($input, $output);
        $style->success("$count jobs requeued.");

        DB::table('failed_jobs')->delete();

        return Command::SUCCESS;
    }
}
