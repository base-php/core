<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class Test extends Command
{
    protected static $defaultName = 'test';

    protected static $defaultDescription = 'Ejecuta las pruebas de la aplicación';

    protected function execute($input, $output)
    {
        system('vendor\bin\pest');
        return Command::SUCCESS;
    }
}
