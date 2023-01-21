<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeMiddleware extends Command
{
    protected static $defaultName = 'make:middleware';

    protected static $defaultDescription = 'Crea una nueva clase de middleware';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/base-php/core/commands/examples/Middleware.php');
        $content = str_replace('MiddlewareName', $name, $content);

        if (! file_exists('app/Middleware')) {
            mkdir('app/Middleware');
        }

        $fopen = fopen('app/Middleware/'.$name.'.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de middleware '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
