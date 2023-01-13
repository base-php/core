<?php

use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class DBTable extends Command
{
    protected static $defaultName = 'db:table';

    protected static $defaultDescription = 'Muestra información sobre la tabla de la base de datos dada';

    public function configure()
    {
        $this->addArgument('table', InputArgument::REQUIRED);
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'Conexión de base de datos a utilizar', 'default');
    }

    protected function execute($input, $output)
    {
        include 'vendor/base-php/core/database/database.php';

        if (!class_exists('Doctrine\DBAL\DriverManager')) {
            $helper = $this->getHelper('question');

            $text = 'La inspección de información de la base de datos requiere el paquete doctrine/dbal ¿Te gustaría instalarlo? (si/no) [no]';
            $question = new ConfirmationQuestion($text, false, '/^(s|y)/i');

            if ($helper->ask($input, $output, $question)) {
                system('composer require doctrine/dbal');
                return Command::SUCCESS;
            }

            return Command::SUCCESS;
        }

        $tableName = $input->getArgument('table');

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

        $exists = DB::getSchemaBuilder($config['database'][$i]['name'])->hasTable($tableName);

        if (!$exists) {
            $style = new SymfonyStyle($input, $output);
            $style->warning("Tabla '$tableName' no existe.");
            return Command::SUCCESS;
        }

        $doctrine = DriverManager::getConnection([
            'dbname' => $config['database'][$i]['database'],
            'user' => $config['database'][$i]['username'],
            'password' => $config['database'][$i]['password'],
            'host' => $config['database'][$i]['host'],
            'driver' => $driver
        ]);

        $schemaManager = $doctrine->createSchemaManager();

        $listTableColumns = count($schemaManager->listTableColumns($tableName));

        $database = $config['database'][$i]['database'];

        if ($config['database'][$i]['driver'] == 'mysql') {
            $size = DB::connection($connection)->select("
                SELECT
                    round(((data_length + index_length) / 1024 / 1024), 2) 'size'
                FROM
                    information_schema.TABLES
                WHERE
                    table_schema = '$database'
                    AND table_name = '$tableName';
            ");
        }

        if ($config['database'][$i]['driver'] == 'sqlsrv') {
            $size = DB::connection($connection)->select("
                SELECT
                    (SUM(a.total_pages) * 8) / 1024 AS size
                FROM
                    sys.tables t
                INNER JOIN
                    sys.partitions p ON t.object_id = p.OBJECT_ID
                INNER JOIN
                    sys.allocation_units a ON p.partition_id = a.container_id
                WHERE
                    t.NAME = '$tableName';
            ");
        }

        if ($config['database'][$i]['driver'] == 'pgsql') {
            $size = DB::connection($connection)->select("
                SELECT
                    pg_size_pretty(pg_total_relation_size('$tableName')) AS size;
            ");
        }

        if ($config['database'][$i]['driver'] == 'sqlite') {
            $size = DB::connection($connection)->select("
                SELECT
                    pgsize
                FROM
                    dbstat
                WHERE
                    name = '$tableName';
            ");
        }

        $size = $size[0]->size;

        $table = new Table($output);
        $table->setHeaders([$tableName, '']);
        $table->setRows([
            ['Columns', $listTableColumns],
            ['Size', $size]
        ]);
        $table->render();

        $table = new Table($output);
        $table->setHeaders(['Columns', 'Attributes', 'Type']);

        foreach ($schemaManager->listTableColumns($tableName) as $column) {
            $name = $column->getName();

            $type = $column->getType();
            $type = get_class($type);
            $type = str_replace('Doctrine\DBAL\Types\\', '', $type);
            $type = str_replace('Type', '', $type);
            $type = strtolower($type);

            $attributes = [];
            $attributes[] = $column->getUnsigned() ? 'unsigned' : '';
            $attributes[] = $column->getNotNull() ? '' : 'nullable';
            $attributes[] = $column->getAutoincrement() ? 'autoincrement' : '';
            $attributes[] = $column->getDefault() ? 'datetime' : '';
            $attributes = array_filter($attributes);
            $attributes = implode(',', $attributes);

            $table->addRow([$name, $attributes, $type]);
        }

        $table->render();

        $table = new Table($output);
        $table->setHeaders(['Index', 'Column', 'Type']);

        foreach ($schemaManager->listTableIndexes($tableName) as $index) {
            $name = $index->getName();
            $column = $index->getColumns()[0];

            $attributes = [];
            $attributes[] = $name == 'PRIMARY' ? 'primary' : '';
            $attributes[] = $index->isUnique() ? 'unique' : '';
            $attributes = array_filter($attributes);
            $attributes = implode(',', $attributes);

            $table->addRow([$name, $column, $attributes]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}
