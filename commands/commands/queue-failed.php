<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueueFailed extends Command
{
    protected static $defaultName = 'queue:failed';

    protected static $defaultDescription = 'Lista de todos los trabajos fallidos en cola';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        include 'vendor/base-php/core/database/database.php';

        $faileds = DB::table('failed_jobs')->get();

        $i = 0;
        $items = [];

        foreach ($faileds as $failed) {
            $job = json_decode($failed->payload)->job;

            $items[$i][] = $failed->date_fail;
            $items[$i][] = $failed->queue;
            $items[$i][] = $job;

            $i++;
        }

        $style = new SymfonyStyle($input, $output);

        $style->table(
            [],
            $items
        );

        return Command::SUCCESS;
    }
}
