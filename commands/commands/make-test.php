<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeTest extends Command
{
    protected static $defaultName = 'make:test';

    protected static $defaultDescription = 'Crea una nueva clase de prueba';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/base-php/core/commands/examples/test.php');
        $content = str_replace('TestName', $name, $content);

        $fopen = fopen('tests/'.$name.'.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de prueba '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
