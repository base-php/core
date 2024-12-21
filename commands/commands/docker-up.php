<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'docker:up', description: 'Ejecuta los contenedores de Docker')]
class DockerUp extends Command
{
    public function configure()
    {
        $this->addOption('detached', 'd', InputOption::VALUE_NONE, 'Ejecuta los contenedores en segundo plano');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $detached = $input->getOption('detached');

        if ($detached) {
            exec('docker-compose up -d');

        } else {
            exec('docker-compose up');
        }

        return Command::SUCCESS;
    }
}
