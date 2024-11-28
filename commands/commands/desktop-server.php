<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'desktop:server', description: 'Ejecuta el servidor de desarrollo en escritorio')]
class DesktopServer extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        system('php -S localhost:8080');
        system('electron .');

        return Command::SUCCESS;
    }
}
