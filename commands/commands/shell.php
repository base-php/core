<?php

use Psy\Shell as Psysh;
use Symfony\Component\Console\Command\Command;

class Shell extends Command
{
    protected static $defaultName = 'shell';

    protected static $defaultDescription = 'Interactuar con tu aplicación';

    protected function execute($input, $output)
    {
        $shell = new Psysh();
        $shell->setIncludes(['vendor/base-php/core/database/database.php']);
        $shell->run();

        return Command::SUCCESS;
    }
}
