<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeJob extends Command
{
    protected static $defaultName = 'make:job';

    protected static $defaultDescription = 'Crea una nueva clase de trabajo';

    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre del trabajo?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/job.php');
        $content = str_replace('JobName', $name, $content);

        if (! file_exists('app/Jobs')) {
            mkdir('app/Jobs');
        }

        $fopen = fopen('app/Jobs/'.$name.'.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de trabajo '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
