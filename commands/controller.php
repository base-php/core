<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class MakeController extends Command
{
    protected static $defaultName = 'make:controller';

    protected static $defaultDescription = 'Create a controller with the given name';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Controller.php');
        $content = str_replace('ControllerName', $name, $content);

        if (!file_exists('app/Controllers')) {
            mkdir('app/Controllers');
        }

        $fopen = fopen('app/Controllers/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $text = "<info>Controller '$name' created successfully.</info>";
        $output->writeln($text);

        return Command::SUCCESS;
    }
}
