<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'docker:stop', description: 'Detiene los contenedores de Docker')]
class DockerStop extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        exec('docker-compose stop');
        return Command::SUCCESS;
    }
}
