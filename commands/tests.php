<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class MakeTest extends Command
{
    protected static $defaultName = 'make:test';

    protected static $defaultDescription = 'Create a test file with the given name';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Test.php');
        $content = str_replace('TestName', $name, $content);

        $fopen = fopen('tests/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $text = "<info>Test '$name' created successfully.</info>";
        $output->writeln($text);

        return Command::SUCCESS;
    }
}
