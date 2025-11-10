<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'module:make-controller', description: 'Crea una nueva clase de controlador en módulo')]
class ModuleMakeController extends Command
{
    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
        $this->addArgument('module', InputArgument::OPTIONAL);

        $this->addOption('api', null, InputOption::VALUE_NONE, 'Excluye del controlador los métodos create y edit');
        $this->addOption('invokable', 'i', InputOption::VALUE_NONE, 'Genera sólo un método, clase de controlador invokable');
        $this->addOption('model', 'm', InputOption::VALUE_REQUIRED, 'Genera el modelo dado');
        $this->addOption('resource', 'r', InputOption::VALUE_NONE, 'Genera una clase de controlador de recurso');
        $this->addOption('validations', null, InputOption::VALUE_NONE, 'Genera clase de validación para store y update');
        $this->addOption('test', null, InputOption::VALUE_NONE, 'Genera una clase de prueba adjunta al controlador');
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
            $question = new Question("\n- ¿Cuál es el nombre del controlador?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $api = $input->getOption('api');
        $invokable = $input->getOption('invokable');
        $model = $input->getOption('model');
        $resource = $input->getOption('resource');
        $validations = $input->getOption('validations');
        $test = $input->getOption('test');

        $file = 'controller';

        if ($api) {
            $file = 'controller.api';
        }

        if ($invokable) {
            $file = 'controller.invokable';
        }

        if ($resource) {
            $file = 'controller.resource';
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/' . $file . '.php');
        $content = str_replace('ControllerName', $name, $content);

        $fopen = fopen('modules/' . $module . '/Controllers/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);
        
        $style->success("Clase de controlador '$name' creado satisfactoriamente.");

        if ($model) {
            $content = file_get_contents('vendor/base-php/core/commands/examples/model.php');
            $content = str_replace('ModelName', $model, $content);

            $fopen = fopen('modules/' . $module . '/Models/' . $model . '.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style->success("Clase de modelo '$model' creada satisfactoriamente.");
        }

        if ($validations) {
            $name = str_replace('Controller', '', $name);

            $validations = [$name . 'StoreValidation', $name . 'UpdateValidation'];

            foreach ($validations as $validation) {
                $content = file_get_contents('vendor/base-php/core/commands/examples/validation.php');
                $content = str_replace('ValidationName', $validation, $content);

                if (! file_exists('modules/' . $module . '/Validations')) {
                    mkdir('modules/' . $module . '/Validations');
                }

                $fopen = fopen('modules/' . $module . '/Validations/' . $validation . '.php', 'w+');
                fwrite($fopen, $content);
                fclose($fopen);

                $style->success("Clase de validación '$validation' creada satisfactoriamente.");                
            }
        }

        if ($test) {
            $content = file_get_contents('vendor/base-php/core/commands/examples/test.php');
            $content = str_replace('TestName', $name, $content);

            $fopen = fopen('modules/' . $module . '/tests/'.$name.'.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style = new SymfonyStyle($input, $output);
            $style->success("Clase de prueba '$name' creada satisfactoriamente.");
        }

        return Command::SUCCESS;
    }
}
