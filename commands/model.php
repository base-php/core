<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class MakeModel extends Command
{
    protected static $defaultName = 'make:model';

    protected static $defaultDescription = 'Create a model file with the given name';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Model.php');
        $content = str_replace('ModelName', $name, $content);

        if (!file_exists('app/Models')) {
            mkdir('app/Models');
        }

        $fopen = fopen('app/Models/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $text = "<info>Model '$name' created successfully.</info>";
        $output->writeln($text);

        return Command::SUCCESS;
    }
}
