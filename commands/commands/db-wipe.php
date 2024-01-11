<?php

use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DBWipe extends Command
{
    protected static $defaultName = 'db:wipe';

    protected static $defaultDescription = 'Eliminar todas las tablas';

    public function configure()
    {
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'Conexión de base de datos a utilizar', 'default');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        include 'vendor/base-php/core/database/database.php';

        if (! class_exists('Doctrine\DBAL\DriverManager')) {
            $helper = $this->getHelper('question');

            $text = 'La inspección de información de la base de datos requiere el paquete doctrine/dbal ¿Te gustaría instalarlo? (si/no) [no]';
            $question = new ConfirmationQuestion($text, false, '/^(s|y)/i');

            if ($helper->ask($input, $output, $question)) {
                exec('composer require doctrine/dbal');

                return Command::SUCCESS;
            }

            return Command::SUCCESS;
        }

        $connection = $input->getOption('database');

        $config = require 'app/config.php';

        $names = array_column($config['database'], 'name');
        $connection = $input->getOption('database');

        $i = array_search($connection, $names);

        if ($config['database'][$i]['driver'] == 'mysql') {
            $driver = 'pdo_mysql';
        }

        if ($config['database'][$i]['driver'] == 'sqlite') {
            $driver = 'pdo_sqlite';
        }

        if ($config['database'][$i]['driver'] == 'pgsql') {
            $driver = 'pdo_pgsql';
        }

        if ($config['database'][$i]['driver'] == 'sqlsrv') {
            $driver = 'pdo_sqlsrv';
        }

        $doctrine = DriverManager::getConnection([
            'dbname' => $config['database'][$i]['database'],
            'user' => $config['database'][$i]['username'],
            'password' => $config['database'][$i]['password'],
            'host' => $config['database'][$i]['host'],
            'driver' => $driver,
        ]);

        $schemaManager = $doctrine->createSchemaManager();

        $schema = $capsule->getConnection($connection)->getSchemaBuilder();

        foreach ($schemaManager->listTables() as $table) {
            $schema->dropIfExists($table->getName());
        }

        $style = new SymfonyStyle($input, $output);
        $style->info('Se eliminaron todas las tablas exitosamente.');

        return Command::SUCCESS;
    }
}
