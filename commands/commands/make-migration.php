<?php

use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeMigration extends Command
{
    protected static $defaultName = 'make:migration';

    protected static $defaultDescription = 'Crea un nuevo archivo de migración';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

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

        $fopen = fopen('database/'.$name.'.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Archivo de migración '$name' creado satisfactoriamente.");

        return Command::SUCCESS;
    }
}
