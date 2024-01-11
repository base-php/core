<?php

use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;


class DBShow extends Command
{
    protected static $defaultName = 'db:show';

    protected static $defaultDescription = 'Muestra información base de datos dada';

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

        $style = new SymfonyStyle($input, $output);

        $config = include 'app/config.php';

        foreach ($config['database'] as $database) {
            $tables = DB::connection($database['name'])
                ->select('SHOW TABLES');

            $tablesSize = count($tables);

            $size = $this->databaseSize($database['name']);

            $style->table(
                [$database['name']],
                [
                    ['Base de datos', $database['database']],
                    ['Servidor', $database['host']],
                    ['Usuario', $database['username']],
                    ['Contraseña', $database['password']],
                    ['Puerto', $database['port']],
                    ['Tablas', $tablesSize],
                    ['Tamaño total', $size]
                ]
            );

            $tablesBody = [];

            foreach ($tables as $table) {
                $key = 'Tables_in_' . $database['database'];
                $tablesBody[] = [$table->$key, $this->databaseTableSize($table->$key, $database['name'])];
            }

            $style->table(
                ['Tablas'],
                $tablesBody
            );
        }

        return Command::SUCCESS;
    }

    public function databaseSize($connection = 'default')
    {
        $database = DB::connection($connection)->getDatabaseName();

        $sql = "
            SELECT
                table_name AS 'table',
                ((data_length + index_length) / 1024 / 1024) AS 'size'
            FROM
                information_schema.TABLES
            WHERE
                table_schema = '$database'
            ORDER BY
                (data_length + index_length) DESC
        ";

        $result = DB::select($sql);

        $size = array_sum(array_column($result, 'size'));
        $size = number_format((float) $size, 2, '.', '');
        return $size;
    }

    public function databaseTableSize($table, $connection = 'default')
    {
        $database = DB::connection($connection)->getDatabaseName();

        $sql = "
            SELECT
                table_name AS 'table',
                ((data_length + index_length) / 1024 / 1024) AS 'size'
            FROM
                information_schema.TABLES
            WHERE
                table_schema = '$database' AND
                table_name = '$table'
            ORDER BY
                (data_length + index_length) DESC
        ";

        $result = DB::select($sql);

        $size = number_format((float) $result[0]->size, 2, '.', '');
        return $size;
    }
}
