<?php

use Symfony\Component\Console\Command\Command;

class Analyse extends Command
{
    protected static $defaultName = 'analyse';

    protected static $defaultDescription = 'Static analysis with PHPStan';

    protected function execute($input, $output)
    {
        system('vendor\bin\phpstan analyse app tests');
        return Command::SUCCESS;
    }
}
