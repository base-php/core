<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeValidation extends Command
{
    protected static $defaultName = 'make:validation';

    protected static $defaultDescription = 'Crea una nueva clase de validación';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/base-php/core/commands/examples/validation.php');
        $content = str_replace('ValidationName', $name, $content);

        if (! file_exists('app/Validations')) {
            mkdir('app/Validations');
        }

        $fopen = fopen('app/Validations/'.$name.'.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de validación '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
