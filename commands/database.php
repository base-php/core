<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class MakeDatabase extends Command
{
    protected static $defaultName = 'make:database';

    protected static $defaultDescription = 'Create a database with the name set in config file';

    public function configure()
    {
        $this->addArgument('connection', InputArgument::OPTIONAL);
    }

    protected function execute($input, $output)
    {
        $connection = ($input->getArgument('connection')) ? $input->getArgument('connection') : 'default';

        include 'vendor/nisadelgado/framework/database.php';

        $config = include('app/config.php');

        foreach ($config['database'] as $item) {
            if ($item['name'] == $connection) {
                $driver     = $item['driver'];
                $host       = $item['host'];
                $username   = $item['username'];
                $password   = $item['password'];
                $database   = $item['database'];
            }
        }

        $database = ($driver == 'sqlite') ? $database . '.sqlite' : $database;

        if ($database != '') {
            if ($driver == 'sqlite') {
                $fopen = fopen($database, 'w+');
                fclose($fopen);
            } else {
                $pdo = new PDO("$driver:host=$host;", $username, $password);
                $pdo->exec('CREATE DATABASE IF NOT EXISTS ' . $database);
            }

            $text = "<info>Database '$database' created successfully.</info>";
        } else {
            $text = "<error>You must set a name for the database in the config.</error>";
        }

        $output->writeln($text);

        return Command::SUCCESS;
    }
}