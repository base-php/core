<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeController extends Command
{
    protected static $defaultName = 'make:controller';

    protected static $defaultDescription = 'Crea una nueva clase de controlador';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
        $this->addOption('all', 'a', InputOption::VALUE_NONE, 'Genera las clases de migración, modelo y controlador.');
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Controller.php');
        $content = str_replace('ControllerName', $name, $content);

        if (!file_exists('app/Controllers')) {
            mkdir('app/Controllers');
        }

        $fopen = fopen('app/Controllers/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Controlador '$name' creado satisfactoriamente.");

        $all = $input->getOption('all');

        if ($all) {
            $model = str()->singular($name);
            $model = str_replace('Controller', '', $model);

            $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Model.php');
            $content = str_replace('ModelName', $model, $content);

            if (!file_exists('app/Models')) {
                mkdir('app/Models');
            }

            $fopen = fopen('app/Models/' . $model . '.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style->success("Modelo '$model' creado satisfactoriamente.");


            $migration = strtolower(str()->snake($model));
            $migration = str()->plural($migration);

            $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Migration.php');
            $content = str_replace('MigrationName', $migration, $content);

            $var = str()->singular($migration);
            $var = strtolower($var);
            $content = str_replace('VarName', $var, $content);

            $model = ucfirst(str()->singular($migration));
            $content = str_replace('ModelName', $model, $content);

            if (!file_exists('database')) {
                mkdir('database');
            }

            $migration = time() . '_' . $migration;

            $fopen = fopen('database/' . $migration . '.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style->success("Migración '$migration' creada satisfactoriamente.");
        }

        return Command::SUCCESS;
    }
}
