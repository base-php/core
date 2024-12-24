<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'docker:down', description: 'Elimina los contenedores de Docker')]
class DockerDown extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        exec('docker-compose down');
        return Command::SUCCESS;
    }
}
