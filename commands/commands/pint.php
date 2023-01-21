<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Pint extends Command
{
    protected static $defaultName = 'pint';

    protected static $defaultDescription = 'Formateador de código PHP';

    protected function execute($input, $output)
    {
        $style = new SymfonyStyle($input, $output);

        system('vendor\bin\pint');

        return Command::SUCCESS;
    }
}
