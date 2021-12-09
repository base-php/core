<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class Test extends Command
{
    protected static $defaultName = 'test';

    protected static $defaultDescription = 'Run unit tests';

    public function configure()
    {
        $this->addArgument('test', InputArgument::OPTIONAL);
    }

    protected function execute($input, $output)
    {
        $test = $input->getArgument('test');

        if ($test) {
            system('vendor\bin\phpunit ' . $test);
        } else {
            system('vendor\bin\phpunit');
        }

        return Command::SUCCESS;
    }
}
