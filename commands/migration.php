<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class MakeMigration extends Command
{
    protected static $defaultName = 'make:migration';

    protected static $defaultDescription = 'Create a migration file with the given name';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Migration.php');
        $content = str_replace('MigrationName', $name, $content);

        if (!file_exists('database')) {
            mkdir('database');
        }

        $name = time() . '_' . $name;

        $fopen = fopen('database/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $text = "<info>Migration '$name' created successfully.</info>";
        $output->writeln($text);

        return Command::SUCCESS;
    }
}
