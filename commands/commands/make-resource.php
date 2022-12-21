<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeResource extends Command
{
    protected static $defaultName = 'make:resource';

    protected static $defaultDescription = 'Crea una nueva clase de recurso';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/base-php/core/commands/examples/Resource.php');
        $content = str_replace('ResourceName', $name, $content);

        if (!file_exists('app/Resources')) {
            mkdir('app/Resources');
        }

        $fopen = fopen('app/Resources/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de recurso '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
