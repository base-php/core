<?php

use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'module:make-migration', description: 'Crea un nuevo archivo de migración en módulo')]
class ModuleMakeMigration extends Command
{
    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
        $this->addArgument('module', InputArgument::OPTIONAL);
        $this->addOption('path', null, InputOption::VALUE_REQUIRED, 'Ubicación donde el archivo de migración será creado');
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
            $question = new Question("\n- ¿Cuál es el nombre de la migración?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/migration.php');
        $content = str_replace('MigrationName', $name, $content);

        $var = Str::singular($name);
        $var = strtolower($var);
        $content = str_replace('VarName', $var, $content);

        $model = ucfirst(Str::singular($name));
        $content = str_replace('ModelName', $model, $content);

        $name = date('Y_m_d_His') . '_' . $name;

        $path = $input->getOption('path') ?? 'modules/' . $module . '/database';

        $fopen = fopen($path . '/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);
        
        $style->success("Archivo de migración '$name' creado satisfactoriamente.");

        return Command::SUCCESS;
    }
}
