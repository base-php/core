<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:database', description: 'Crea las bases de datos establecidas en el archivo config')]
class MakeDatabase extends Command
{
    public function configure()
    {
        $this->addArgument('connection', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $connection = ($input->getArgument('connection')) ? $input->getArgument('connection') : 'default';

        include 'vendor/base-php/core/database/database.php';

        $config = include 'app/config.php';

        $style = new SymfonyStyle($input, $output);

        foreach ($config['database'] as $item) {
            if ($item['name'] == $connection) {
                $driver = $item['driver'];
                $host = $item['host'];
                $username = $item['username'];
                $password = $item['password'];
                $database = $item['database'];
                $port = $item['port'];
            }
        }

        $database = ($driver == 'sqlite') ? $database.'.sqlite' : $database;

        if ($database != '') {
            if ($driver == 'sqlite') {
                $fopen = fopen($database, 'w+');
                fclose($fopen);
            }

            if ($driver == 'mysql') {
                $pdo = new PDO("$driver:host=$host;port=$port", $username, $password);
                $pdo->exec('CREATE DATABASE IF NOT EXISTS '.$database);
            }

            if ($driver == 'pgsql') {
                $pdo = new PDO("$driver:host=$host;port=$port", $username, $password);
                $pdo->exec('CREATE DATABASE '.$database);
            }

            if ($driver == 'sqlsrv') {
                $pdo = new PDO("$driver:server=$host;port=$port", $username, $password);
                $pdo->exec('CREATE DATABASE '.$database);
            }

            $style->success("Base de datos '$database' en '$driver' creada satisfactoriamente.");
        } else {
            $style->error('Debe establecer un nombre para la base de datos en el archivo config.');
        }

        return Command::SUCCESS;
    }
}
