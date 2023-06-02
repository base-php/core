<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeController extends Command
{
    protected static $defaultName = 'make:controller';

    protected static $defaultDescription = 'Crea una nueva clase de controlador';

    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);

        $this->addOption('api', null, InputOption::VALUE_NONE, 'Excluye del controlador los métodos create y edit');
        $this->addOption('invokable', 'i', InputOption::VALUE_NONE, 'Genera sólo un método, clase de controlador invokable');
        $this->addOption('model', 'm', InputOption::VALUE_REQUIRED, 'Genera el modelo dado');
        $this->addOption('resource', 'r', InputOption::VALUE_NONE, 'Genera una clase de controlador de recurso');
        $this->addOption('validations', null, InputOption::VALUE_NONE, 'Genera clase de validación para store y update');
        $this->addOption('test', null, InputOption::VALUE_NONE, 'Genera una clase de prueba adjunta al controlador');
    }

    protected function execute($input, $output)
    {
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

        $fopen = fopen('app/Controllers/'.$name.'.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de controlador '$name' creado satisfactoriamente.");

        if ($model) {
            $content = file_get_contents('vendor/base-php/core/commands/examples/model.php');
            $content = str_replace('ModelName', $model, $content);

            $fopen = fopen('app/Models/'.$model.'.php', 'w+');
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

                if (! file_exists('app/Validations')) {
                    mkdir('app/Validations');
                }

                $fopen = fopen('app/Validations/'.$validation.'.php', 'w+');
                fwrite($fopen, $content);
                fclose($fopen);

                $style->success("Clase de validación '$validation' creada satisfactoriamente.");                
            }
        }

        if ($test) {
            $content = file_get_contents('vendor/base-php/core/commands/examples/test.php');
            $content = str_replace('TestName', $name, $content);

            $fopen = fopen('tests/'.$name.'.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style = new SymfonyStyle($input, $output);
            $style->success("Clase de prueba '$name' creada satisfactoriamente.");
        }

        return Command::SUCCESS;
    }
}
