<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class Migrate extends Command
{
    protected static $defaultName = 'migrate';

    protected static $defaultDescription = 'Migrate all files to database';

    public function configure()
    {
        $this->addArgument('file', InputArgument::OPTIONAL);
    }

    protected function execute($input, $output)
    {
        include 'vendor/nisadelgado/framework/database.php';

        $config = include 'app/config.php';

        foreach ($config['database'] as $item) {
            $name = $item['name'];
            $schema[$name] = $capsule->getConnection($name)->getSchemaBuilder();
        }

        $file = $input->getArgument('file');

        $style = new SymfonyStyle($input, $output);

        if ($file) {
            if (file_exists('database/' . $file)) {
                include 'database/' . $file;
                $style->success("$file is ok.");

            } else {
                $style->error("The file '$file' does not exist.");
            }

        } else {
            $scandir = scandir('database');

            foreach ($scandir as $item) {
                if (!is_dir($item)) {
                    include 'database/' . $item;
                    $style->success("$item is ok.");
                }
            }
        }

        return Command::SUCCESS;
    }
}
