<?php

use Symfony\Component\Console\Command\Command;

use Psy\Shell as Psysh;

class Shell extends Command
{
    protected static $defaultName = 'shell';

    protected static $defaultDescription = 'Enter to interactive shell';

    protected function execute($input, $output)
    {
        $shell = new Psysh();
        $shell->setIncludes(['vendor/nisadelgado/framework/database.php']);
        $shell->run();
        return Command::SUCCESS;
    }
}
