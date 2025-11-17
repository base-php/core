<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'module:make-test', description: 'Crea una nueva clase de prueba en módulo')]
class ModuleMakeTest extends Command
{
    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $module = $input->getArgument('module');

        if (! $module) {
            if (! file_exists('vendor/base-php/core/tmp/module')) {
                $style->error('No hay ningún módulo seleccionado. Usa el comando module:use para seleccionar un módulo.');
                return Command::FAILURE;
            }

            $module = file_get_contents('vendor/base-php/core/tmp/module');
        }

        while (! $module) {
            $question = new Question("\n- ¿Cuál es el nombre del módulo?\n> ");

            $helper = $this->getHelper('question');
            $module = $helper->ask($input, $output, $question);
        }

        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre de la prueba?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }


        $content = file_get_contents('vendor/base-php/core/commands/examples/test.php');
        $content = str_replace('TestName', $name, $content);

        $fopen = fopen('modules/' . $module . '/tests/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);
        
        $style->success("Clase de prueba '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
