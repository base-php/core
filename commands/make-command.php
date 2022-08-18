<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeCommand extends Command
{
    protected static $defaultName = 'make:command';

    protected static $defaultDescription = 'Crea una nueva clase de comando';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/base-php/core/commands/examples/Command.php');
        $content = str_replace('CommandName', $name, $content);

        if (!file_exists('app/Commands')) {
            mkdir('app/Commands');
        }

        $fopen = fopen('app/Commands/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de comando '$name' created successfully.");

        return Command::SUCCESS;
    }
}
