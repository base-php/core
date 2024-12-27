<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'docker:npm', description: 'Ejecuta comandos de NPM en el contenedor')]
class DockerNpm extends Command
{
    public function configure()
    {
        $this->addArgument('commands', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $commands = $input->getArgument('commands');
        exec("docker-compose exec apache npm $commands");
        return Command::SUCCESS;
    }
}
