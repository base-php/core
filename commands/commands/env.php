<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'env', description: 'Muestra el entorno actual del framework')]
class Env extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = require 'app/config.php';

        $environment = $config['environment'];

        $style = new SymfonyStyle($input, $output);
        $style->text("El entorno de la aplicación es [$environment].");
        $style->newLine();

        return Command::SUCCESS;
    }
}
