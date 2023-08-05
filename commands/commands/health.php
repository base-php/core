<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class HealthCmd extends Command
{
    protected static $defaultName = 'health';

    protected static $defaultDescription = 'Muestra información de salud de su aplicación';

    protected function execute($input, $output)
    {
        $style = new SymfonyStyle($input, $output);

        $config = include 'app/config.php';

        $i = 0;

        if (strposToArray('cpuUsage', $config['health'])) {
            $i = strposToArray('cpuUsage', $config['health']);
            $item = $config['health'][$i];

            $explode = explode(':', $item);
            $param = $explode[1];

            $this->items[$i][] = 'Uso de CPU';
            $this->items[$i][] = $this->cpuUsage($param);

            $percent = str_replace('%', '', $this->cpuUsage($param));

            $i++;
        }

        if (strposToArray('databaseConnection', $config['health'])) {
            $i = strposToArray('databaseConnection', $config['health']);
            $item = $config['health'][$i];

            $explode = explode(':', $item);
            $param = $explode[1];

            $this->items[$i][] = 'Conexión a base de datos: ' . $param;
            $this->items[$i][] = $this->databaseConnection($param);

            $i++;
        }

        if (strposToArray('databaseSize', $config['health'])) {
            $i = strposToArray('databaseSize', $config['health']);
            $item = $config['health'][$i];

            $explode = explode(':', $item);
            $param = $explode[1];

            $this->items[$i][] = 'Tamaño de la base de datos: ' . $param;
            $this->items[$i][] = $this->databaseSize($param);

            $i++;
        }

        if (strposToArray('databaseTableSize', $config['health'])) {
            $i = strposToArray('databaseTableSize', $config['health']);
            $item = $config['health'][$i];

            $explode = explode(':', $item);
            $params = explode(',', $explode[1]);

            $this->items[$i][] = 'Tamaño de la tabla de la base de datos: ' . $params[0];
            $this->items[$i][] = $this->databaseTableSize($params[1], $params[0]);

            $i++;
        }

        if (in_array('debug', $config['health'])) {
            $this->items[$i][] = 'Debug';
            $this->items[$i][] = $this->debug();

            $i++;
        }

        if (in_array('environment', $config['health'])) {
            $this->items[$i][] = 'Entorno';
            $this->items[$i][] = $this->environment();

            $i++;
        }

        if (strposToArray('ping', $config['health'])) {
            $i = strposToArray('ping', $config['health']);
            $item = $config['health'][$i];

            $explode = explode(':', $item);

            $url = $explode[1];

            $this->items[$i][] = 'Ping a: ' . $url;
            $this->items[$i][] = $this->ping($url);

            $i++;
        }

        if (in_array('securityAdvisoriesPackages', $config['health'])) {
            $this->items[$i][] = 'Avisos de seguridad en paquetes';
            $this->items[$i][] = $this->securityAdvisoriesPackages();

            $i++;
        }

        if (strposToArray('usedDiskSpace', $config['health'])) {
            $i = strposToArray('usedDiskSpace', $config['health']);
            $item = $config['health'][$i];

            $explode = explode(':', $item);

            $percent = $explode[1];

            $this->items[$i][] = 'Uso de espacio en disco';
            $this->items[$i][] = $this->usedDiskSpace();

            $i++;
        }

        $style->table(
            ['Nombre', 'Resultado'],
            $items
        );

        return Command::SUCCESS;
    }
}
