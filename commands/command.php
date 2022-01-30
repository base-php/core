<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class MakeCommand extends Command
{
    protected static $defaultName = 'make:command';

    protected static $defaultDescription = 'Create a command with the given name';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Command.php');
        $content = str_replace('CommandName', $name, $content);

        if (!file_exists('app/Commands')) {
            mkdir('app/Commands');
        }

        $fopen = fopen('app/Commands/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $text = "<info>Command '$name' created successfully.</info>";
        $output->writeln($text);

        return Command::SUCCESS;
    }
}