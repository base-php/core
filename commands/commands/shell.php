<?php

use Psy\Shell as Psysh;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'shell', description: 'Interactuar con tu aplicación')]
class Shell extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $shell = new Psysh();
        $shell->setIncludes(['vendor/base-php/core/database/database.php']);
        $shell->run();

        return Command::SUCCESS;
    }
}
