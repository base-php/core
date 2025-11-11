<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'module:make-model', description: 'Crea una nueva clase de modelo en módulo')]
class ModuleMakeModel extends Command
{
    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
        $this->addArgument('module', InputArgument::OPTIONAL);

        $this->addOption('all', 'a', InputOption::VALUE_NONE, 'Genera las clases de migración, modelo y controlador');
        $this->addOption('controller', 'c', InputOption::VALUE_NONE, 'Crea un nuevo controlador para el modelo');
        $this->addOption('migration', 'm', InputOption::VALUE_NONE, 'Crea una nueva migración para el modelo');
        $this->addOption('resource', 'r', InputOption::VALUE_NONE, 'Indica si el controlador generado debe ser un controlador de recursos');
        $this->addOption('api', null, InputOption::VALUE_NONE, 'Indica si el controlador generado debe ser un controlador de recursos API');
        $this->addOption('validations', null, InputOption::VALUE_NONE, 'Crea nueva clase de validación y las utiliza en el controlador');
        $this->addOption('test', null, InputOption::VALUE_NONE, 'Genera una clase de prueba adjunta al modelo');
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
            $question = new Question("\n- ¿Cuál es el nombre del modelo?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/model.php');
        $content = str_replace('ModelName', $name, $content);

        if (! file_exists('modules/' . $module . '/Models')) {
            mkdir('modules/' . $module . '/Models');
        }

        $fopen = fopen('modules/' . $module . '/Models/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);
        
        $style->success("Clase de modelo '$name' creado satisfactoriamente.");

        $all = $input->getOption('all');

        $controller = $input->getOption('controller');

        if ($controller || $all) {
            $controllerName = $name . 'Controller';

            $content = file_get_contents('vendor/base-php/core/commands/examples/controller.php');
            $content = str_replace('ControllerName', $controllerName, $content);
            $content = str_replace('App\Controllers', 'Modules\\' . $module . '\Controllers', $content);

            $fopen = fopen('modules/' . $module . '/Controllers/' . $controllerName . '.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style = new SymfonyStyle($input, $output);
            $style->success("Clase de controlador '$controllerName' creado satisfactoriamente.");
        }

        $migration = $input->getOption('migration');

        if ($migration || $all) {
            $migrationName = str($name)->plural()->slug();

            $content = file_get_contents('vendor/base-php/core/commands/examples/Migration.php');
            $content = str_replace('MigrationName', $migrationName, $content);

            $migrationName = date('Y_m_d_His') . '_' . $migrationName;

            $fopen = fopen('modules/' . $module . '/database/' . $migrationName . '.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style = new SymfonyStyle($input, $output);
            $style->success("Archivo de migración '$migrationName' creado satisfactoriamente.");
        }

        $resource = $input->getOption('resource');

        if ($resource || $all) {
            $file = 'controller.resource';
            $controllerName = $name . 'Controller';

            $content = file_get_contents('vendor/base-php/core/commands/examples/' . $file . '.php');
            $content = str_replace('ControllerName', $controllerName, $content);
            $content = str_replace('App\Controllers', 'Modules\\' . $module . '\Controllers', $content);

            $fopen = fopen('modules/' . $module . '/Controllers/' . $controllerName . '.php', 'w+');
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
            $content = str_replace('App\Controllers', 'Modules\\' . $module . '\Controllers', $content);

            $fopen = fopen('modules/' . $module . '/Controllers/' . $controllerName . '.php', 'w+');
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
                $content = str_replace('App\Validations', 'Modules\\' . $module . '\Validations', $content);

                if (! file_exists('modules/' . $module . '/Validations')) {
                    mkdir('modules/' . $module . '/Validations');
                }

                $fopen = fopen('modules/' . $module . '/Validations/' . $validation . '.php', 'w+');
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

            $fopen = fopen('modules/' . $module . '/tests/' . $name . '.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style = new SymfonyStyle($input, $output);
            $style->success("Clase de prueba '$name' creada satisfactoriamente.");
        }

        return Command::SUCCESS;
    }
}
