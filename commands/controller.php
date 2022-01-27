<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeController extends Command
{
    protected static $defaultName = 'make:controller';

    protected static $defaultDescription = 'Create a controller with the given name';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
        $this->addOption('all', 'a', InputOption::VALUE_NONE, 'Create migration, model and controller');
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

        $output->writeln("<info>Controller '$name' created successfully.</info>");

        $all = $input->getOption('all');

        if ($all) {
            $model = str()->singular($name);
            $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Model.php');
            $content = str_replace('ModelName', $model, $content);

            if (!file_exists('app/Models')) {
                mkdir('app/Models');
            }

            $fopen = fopen('app/Models/' . $model . '.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $output->writeln("<info>Model '$model' created successfully.</info>");


            $migration = strtolower(str()->snake($name));

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

            $output->writeln("<info>Migration '$migration' created successfully.</info>");
        }

        return Command::SUCCESS;
    }
}
