<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'module:make-resource', description: 'Crea una nueva clase de recurso en módulo')]
class ModuleMakeResource extends Command
{
    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
        $this->addArgument('module', InputArgument::OPTIONAL);
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

        if (! file_exists("modules/$module")) {
            $style->error("El módulo '$module' no existe.");
            return Command::FAILURE;
        }

        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre del recurso?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/resource.php');
        $content = str_replace('ResourceName', $name, $content);
        $content = str_replace('App\Resources', 'Modules\\' . $module . '\Resources', $content);

        if (! file_exists('modules/' . $module . '/Resources')) {
            mkdir('modules/' . $module . '/Resources');
        }

        $fopen = fopen('modules/' . $module . '/Resources/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);
        
        $style->success("Clase de recurso '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
