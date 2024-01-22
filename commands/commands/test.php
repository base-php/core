<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'test', description: 'Ejecuta las pruebas de la aplicación')]
class Test extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        system('vendor\bin\pest');
        return Command::SUCCESS;
    }
}
