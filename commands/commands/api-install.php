<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'api:install', description: 'Instala framework en modo API')]
class ApiInstall extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
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
