<?php

use Symfony\Component\Console\Command\Command;

class Server extends Command
{
    protected static $defaultName = 'server';

    protected static $defaultDescription = 'Build development server on port 8080';

    protected function execute($input, $output)
    {
        system('php -S localhost:8080');
        return Command::SUCCESS;
    }
}
