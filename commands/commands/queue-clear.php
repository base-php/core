<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueueClear extends Command
{
    protected static $defaultName = 'queue:clear';

    protected static $defaultDescription = 'Borra todos los trabajos de la cola especificada';

    public function configure()
    {
        $this->addArgument('queue', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        include 'vendor/base-php/core/database/database.php';

        $queue = $input->getArgument('queue') ?? 'default';

        $count = DB::table('jobs')
            ->where('queue', $queue)
            ->get();

        $count = $count->count();

        DB::table('jobs')
            ->where('queue', $queue)
            ->delete();

        $style = new SymfonyStyle($input, $output);
        $style->success("$count trabajos borrados de la cola [$queue].");

        return Command::SUCCESS;
    }
}
