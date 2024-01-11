<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Pint extends Command
{
    protected static $defaultName = 'pint';

    protected static $defaultDescription = 'Formateador de código PHP';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        system('vendor\bin\pint');

        return Command::SUCCESS;
    }
}
