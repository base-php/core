<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'desktop:install', description: 'Instala todo los recursos para el desarrollo de escritorio')]
class DesktopInstall extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        system('npm install -g electron');

        $style = new SymfonyStyle($input, $output);
        $style->success('Desarrollo de escritorio instalado satisfactoriamente.');

        return Command::SUCCESS;
    }
}
