<?php

use Symfony\Component\Console\Command\Command;

class Test extends Command
{
    protected static $defaultName = 'test';

    protected static $defaultDescription = 'Run unit tests';

    protected function execute($input, $output)
    {
        system('vendor\bin\phpunit');
        return Command::SUCCESS;
    }
}
