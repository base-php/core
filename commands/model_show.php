<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class ModelShow extends Command
{
    protected static $defaultName = 'model:show';

    protected static $defaultDescription = 'Muestra información de un modelo Eloquent';

    public function configure()
    {
        $this->addArgument('model', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        include 'vendor/nisadelgado/framework/database.php';

        $model = $input->getArgument('model');

        $config = require 'app/config.php';
        include 'vendor/nisadelgado/framework/database.php';

        foreach ($config['database'] as $item) {
            $name = $item['name'];
            $schema[$name] = $capsule->getConnection($name)->getSchemaBuilder();
        }

        $class = 'App\Models\\' . $model;

        $class = new $class();

        $connection = $class->connection ? $class->connection : 'default';
        $i = array_search($connection, array_column($config['database'], 'name'));
        $database = $config['database'][$i]['driver'] ?? '';

        $table = $class->getTable();

        $attributes = [];
        $fields = [];

        if ($database == 'mysql') {
            $fields = DB::select("SHOW COLUMNS FROM $table");
            $field_column = 'Field';
            $type_column = 'Type';
        }

        if ($database == 'pgsql') {
            $fields = DB::select("SELECT * FROM information_schema.columns WHERE table_name = '$table'");
            $field_column = 'column_name';
            $type_column = 'udt_name';
        }

        if ($database == 'sqlsrv') {
            $fields = DB::select("SELECT * FROM information_schema.columns WHERE table_name = '$table'");
            $field_column = 'COLUMN_NAME';
            $type_column = 'DATA_TYPE';
        }

        if ($database == 'sqlite') {
            $fields = DB::select("PRAGMA table_info($table)");
            $field_column = 'name';
            $type_column = 'type';
        }

        if (count($fields)) {
            foreach ($fields as $field) {
                $attributes[] = [$field->$field_column, $field->$type_column];
            }            
        }

        if ($database == 'mongodb') {
            $attributes[] = ['Esta característica no está disponible para este controlador'];
        }

        $methods = get_class_methods($class);

        $definedPerUserMethods = array_splice($methods, 0, array_search('getFillable', $methods));

        foreach ($definedPerUserMethods as $method) {
            try {
                if (strpos(get_class($class->$method()), 'Database\Eloquent\Relations')) {
                    $type = str_replace('Illuminate\Database\Eloquent\Relations\\', '', get_class($class->$method()));
                    $related = str_replace('App\Models\\', '', get_class($class->$method()->getRelated()));
                    $relations[] = [$method, $type, $related];
                }
            } catch (ArgumentCountError $exception) {

            }
        }

        $style = new SymfonyStyle($input, $output);

        $style->table(
            ['App\Models\\' . $model, ''],

            [
                ['Base de datos', $database],
                ['Tabla', $table],
            ]
        );

        $style->table(
            ['Atributos'],

            $attributes
        );

        $style->table(
            ['Relaciones'],

            $relations
        );

        return Command::SUCCESS;
    }
}
