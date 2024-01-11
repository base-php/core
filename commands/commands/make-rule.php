<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeRule extends Command
{
    protected static $defaultName = 'make:rule';

    protected static $defaultDescription = 'Crea una nueva clase de regla';

    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre de la regla?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/rule.php');
        $content = str_replace('RuleName', $name, $content);

        if (! file_exists('app/Rules')) {
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
