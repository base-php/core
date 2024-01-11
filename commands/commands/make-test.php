<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeTest extends Command
{
    protected static $defaultName = 'make:test';

    protected static $defaultDescription = 'Crea una nueva clase de prueba';

    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre de la prueba?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }


        $content = file_get_contents('vendor/base-php/core/commands/examples/test.php');
        $content = str_replace('TestName', $name, $content);

        $fopen = fopen('tests/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de prueba '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
