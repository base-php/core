<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'docker:php', description: 'Ejecuta comandos de PHP en el contenedor')]
class DockerPhp extends Command
{
    public function configure()
    {
        $this->addArgument('commands', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $commands = $input->getArgument('commands');
        exec("docker-compose exec apache php $commands");
        return Command::SUCCESS;
    }
}
