<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeModel extends Command
{
    protected static $defaultName = 'make:model';

    protected static $defaultDescription = 'Crea una nueva clase de modelo';

    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
        $this->addOption('all', 'a', InputOption::VALUE_NONE, 'Genera las clases de migración, modelo y controlador.');

        $this->addOption('resource', 'r', InputOption::VALUE_NONE, 'Indica si el controlador generado debe ser un controlador de recursos');
        $this->addOption('api', null, InputOption::VALUE_NONE, 'Indica si el controlador generado debe ser un controlador de recursos API');
        $this->addOption('validations', null, InputOption::VALUE_NONE, 'Crea nueva clase de validación y las utiliza en el controlador');
        $this->addOption('test', null, InputOption::VALUE_NONE, 'Genera una clase de prueba adjunta al modelo');
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre del modelo?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/model.php');
        $content = str_replace('ModelName', $name, $content);

        if (! file_exists('app/Models')) {
            mkdir('app/Models');
        }

        $fopen = fopen('app/Models/'.$name.'.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de modelo '$name' creado satisfactoriamente.");

        $all = $input->getOption('all');

        $resource = $input->getOption('resource');

        if ($resource || $all) {
            $file = 'controller.resource';
            $controllerName = $name . 'Controller';

            $content = file_get_contents('vendor/base-php/core/commands/examples/' . $file . '.php');
            $content = str_replace('ControllerName', $controllerName, $content);

            $fopen = fopen('app/Controllers/' . $controllerName . '.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style = new SymfonyStyle($input, $output);
            $style->success("Clase de controlador '$controllerName' creada satisfactoriamente.");
        }

        $api = $input->getOption('api');

        if ($api) {
            $file = 'controller.api';
            $controllerName = $name . 'Controller';

            $content = file_get_contents('vendor/base-php/core/commands/examples/' . $file . '.php');
            $content = str_replace('ControllerName', $controllerName, $content);

            $fopen = fopen('app/Controllers/' . $controllerName . '.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style = new SymfonyStyle($input, $output);
            $style->success("Clase de controlador '$controllerName' creada satisfactoriamente.");
        }

        $validations = $input->getOption('validations');

        if ($validations || $all) {
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

                $style = new SymfonyStyle($input, $output);
                $style->success("Clase de validación '$validation' creada satisfactoriamente.");
            }
        }

        $test = $input->getOption('test');

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
