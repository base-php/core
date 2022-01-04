<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class Server extends Command
{
    protected static $defaultName = 'server';

    protected static $defaultDescription = 'Build development server';

    public function configure()
    {
        $this->addArgument('port', InputArgument::OPTIONAL);
    }

    protected function execute($input, $output)
    {
        $port = ($input->getArgument('port')) ? $input->getArgument('port') : 8080;
        system('php -S localhost:' . $port);
        return Command::SUCCESS;
    }
}
