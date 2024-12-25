<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'docker:base', description: 'Ejecuta comandos de Base PHP en el contenedor')]
class DockerBase extends Command
{
    public function configure()
    {
        $this->addArgument('commands', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $commands = $input->getArgument('commands');
        $command = "php base $commands";
        exec("docker-compose exec apache $command");
        return Command::SUCCESS;
    }
}
