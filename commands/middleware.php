<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class MakeMiddleware extends Command
{
    protected static $defaultName = 'make:middleware';

    protected static $defaultDescription = 'Create a middleware with the given name';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Middleware.php');
        $content = str_replace('MiddlewareName', $name, $content);

        if (!file_exists('app/Middleware')) {
            mkdir('app/Middleware');
        }

        $fopen = fopen('app/Middleware/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $text = "<info>Middleware '$name' created successfully.</info>";
        $output->writeln($text);

        return Command::SUCCESS;
    }
}
