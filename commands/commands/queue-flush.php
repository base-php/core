<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'queue:flush', description: 'Borra todos los trabajos fallidos en cola')]
class QueueFlush extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        include 'vendor/base-php/core/database/database.php';

        DB::table('failed_jobs')
            ->delete();

        $style = new SymfonyStyle($input, $output);
        $style->success('Todos los trabajos fallidos fueron borrados.');

        return Command::SUCCESS;
    }
}
