<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'server', description: 'Servir la aplicación en el servidor de desarrollo de PHP')]
class Server extends Command
{
    public function configure()
    {
        $this->addArgument('port', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $port = ($input->getArgument('port')) ? $input->getArgument('port') : 8080;

        system('php -S localhost:'.$port);

        return Command::SUCCESS;
    }
}
