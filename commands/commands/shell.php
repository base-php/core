<?php

use Psy\Shell as Psysh;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Shell extends Command
{
    protected static $defaultName = 'shell';

    protected static $defaultDescription = 'Interactuar con tu aplicación';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $shell = new Psysh();
        $shell->setIncludes(['vendor/base-php/core/database/database.php']);
        $shell->run();

        return Command::SUCCESS;
    }
}
