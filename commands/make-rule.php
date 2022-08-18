<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeRule extends Command
{
    protected static $defaultName = 'make:rule';

    protected static $defaultDescription = 'Crea una nueva clase de regla';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/base-php/core/commands/examples/Rule.php');
        $content = str_replace('RuleName', $name, $content);

        if (!file_exists('app/Rules')) {
            mkdir('app/Rules');
        }

        $fopen = fopen('app/Rules/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de regla '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
