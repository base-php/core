<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class ApiInstall extends Command
{
    protected static $defaultName = 'api:install';

    protected static $defaultDescription = 'Instala framework en modo API';

    protected function execute($input, $output)
    {
        system('rm -rf resources');
        system('rm -rf node_modules');
        system('rm -rf app/Controllers/HomeController.php');

        copy('vendor/base-php/core/commands/examples/api-controller.php', 'app/Controllers/HomeController.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Modo API instalado satisfactoriamente.');

        return Command::SUCCESS;
    }
}
