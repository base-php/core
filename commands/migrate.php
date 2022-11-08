<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class Migrate extends Command
{
    protected static $defaultName = 'migrate';

    protected static $defaultDescription = 'Ejecuta las migraciones de base de datos';

    public function configure()
    {
        $this->addArgument('file', InputArgument::OPTIONAL);
    }

    protected function execute($input, $output)
    {
        include 'vendor/base-php/core/database.php';

        $config = include 'app/config.php';

        foreach ($config['database'] as $item) {
            $name = $item['name'];
            $schema[$name] = $capsule->getConnection($name)->getSchemaBuilder();
            $schema[$name]->disableForeignKeyConstraints();
        }

        $file = $input->getArgument('file');

        $style = new SymfonyStyle($input, $output);

        if ($file) {
            if (file_exists('database/' . $file)) {
                include 'database/' . $file;
                $style->success("$file está ok.");

            } else {
                $style->error("El archivo '$file' no existe.");
            }

        } else {
            $scandir = scandir('database');

            foreach ($scandir as $item) {
                if (!is_dir($item)) {
                    include 'database/' . $item;
                    $style->success("$item está ok.");
                }
            }
        }

        return Command::SUCCESS;
    }
}
