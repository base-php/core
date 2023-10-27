<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class HealthCmd extends Command
{
    protected static $defaultName = 'health';

    protected static $defaultDescription = 'Muestra información de salud de su aplicación';

    protected function execute($input, $output)
    {
        require 'vendor/base-php/core/database/database.php';

        $style = new SymfonyStyle($input, $output);

        $config = include 'app/config.php';
        array_unshift($config['health'], '');

        $i = 0;

        $health = new Health();

        if (strposToArray('databaseConnection', $config['health'])) {
            $i = strposToArray('databaseConnection', $config['health']);
            $item = $config['health'][$i];

            $explode = explode(':', $item);
            $param = $explode[1];

            $this->items[$i][] = 'Conexión a base de datos: ' . $param;
            $this->items[$i][] = $health->databaseConnection($param);

            $i++;
        }

        if (strposToArray('databaseSize', $config['health'])) {
            $i = strposToArray('databaseSize', $config['health']);
            $item = $config['health'][$i];

            $explode = explode(':', $item);
            $param = $explode[1];

            $this->items[$i][] = 'Tamaño de la base de datos: ' . $param;
            $this->items[$i][] = $health->databaseSize($param);

            $i++;
        }

        if (strposToArray('databaseTableSize', $config['health'])) {
            $i = strposToArray('databaseTableSize', $config['health']);
            $item = $config['health'][$i];

            $explode = explode(':', $item);
            $params = explode(',', $explode[1]);

            $table = $params[0];
            $database = $params[1] ?? 'default';

            $this->items[$i][] = "Tamaño de la tabla '$table' en la conexión '$database'";
            $this->items[$i][] = $health->databaseTableSize($table, $database);

            $i++;
        }

        if (in_array('debug', $config['health'])) {
            $this->items[$i][] = 'Debug';
            $this->items[$i][] = $health->debug();

            $i++;
        }

        if (in_array('environment', $config['health'])) {
            $this->items[$i][] = 'Entorno';
            $this->items[$i][] = $health->environment();

            $i++;
        }

        if (strposToArray('ping', $config['health'])) {
            $i = strposToArray('ping', $config['health']);
            $item = $config['health'][$i];

            $explode = explode(':', $item);

            $url = $explode[1];

            $this->items[$i][] = 'Ping a: ' . $url;
            $this->items[$i][] = $health->ping($url);

            $i++;
        }

        if (strposToArray('usedDiskSpace', $config['health'])) {
            $i = strposToArray('usedDiskSpace', $config['health']);
            $item = $config['health'][$i];

            $this->items[$i][] = 'Uso de espacio en disco';
            $this->items[$i][] = $health->usedDiskSpace();

            $i++;
        }

        $style->table(
            ['Nombre', 'Resultado'],
            $this->items
        );

        return Command::SUCCESS;
    }
}
