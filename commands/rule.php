<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class MakeRule extends Command
{
    protected static $defaultName = 'make:rule';

    protected static $defaultDescription = 'Create a rule file with the given name';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Rule.php');
        $content = str_replace('RuleName', $name, $content);

        if (!file_exists('app/Rules')) {
            mkdir('app/Rules');
        }

        $fopen = fopen('app/Rules/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $text = "<info>Rule '$name' created successfully.</info>";
        $output->writeln($text);

        return Command::SUCCESS;
    }
}
