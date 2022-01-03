<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class Expose extends Command
{
    protected static $defaultName = 'expose';

    protected static $defaultDescription = 'Expose local sites via secure tunnels';

    public function configure()
    {
        $this->addArgument('url', InputArgument::OPTIONAL);
    }

    protected function execute($input, $output)
    {
        $url = ($input->getArgument('url')) ? $input->getArgument('url') : 'localhost:8080';
        system('vendor\bin\expose share ' . $url);
        return Command::SUCCESS;
    }
}
