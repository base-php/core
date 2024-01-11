<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Test extends Command
{
    protected static $defaultName = 'test';

    protected static $defaultDescription = 'Ejecuta las pruebas de la aplicación';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        system('vendor\bin\pest');
        return Command::SUCCESS;
    }
}
