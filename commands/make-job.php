<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeJob extends Command
{
    protected static $defaultName = 'make:job';

    protected static $defaultDescription = 'Crea una nueva clase de trabajo';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/base-php/core/commands/examples/Job.php');
        $content = str_replace('JobName', $name, $content);

        if (!file_exists('app/Jobs')) {
        	mkdir('app/Jobs');
        }

        $fopen = fopen('app/Jobs/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de trabajo '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
