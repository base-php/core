<?php

use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeMigration extends Command
{
    protected static $defaultName = 'make:migration';

    protected static $defaultDescription = 'Crea un nuevo archivo de migración';

    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
        $this->addOption('path', null, InputOption::VALUE_REQUIRED, 'Ubicación donde el archivo de migración será creado');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre de la migración?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/Migration.php');
        $content = str_replace('MigrationName', $name, $content);

        $var = Str::singular($name);
        $var = strtolower($var);
        $content = str_replace('VarName', $var, $content);

        $model = ucfirst(Str::singular($name));
        $content = str_replace('ModelName', $model, $content);

        if (! file_exists('database')) {
            mkdir('database');
        }

        $name = date('Y_m_d_His').'_'.$name;

        $path = $input->getOption('path') ?? 'database';

        $fopen = fopen($path . '/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Archivo de migración '$name' creado satisfactoriamente.");

        return Command::SUCCESS;
    }
}
