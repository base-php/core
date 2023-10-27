<?php

class Health
{
	public function databaseConnection($connection = 'default')
	{
		try {
			DB::connection($connection)->getPDO();
			return 'ok';
		}

		catch (Exception $exception) {
			return 'error';
		}
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

	public function databaseTableSize($table, $connection)
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

	public function debug()
	{
		$config = include 'app/config.php';
		return $config['errors'] ? 'true' : 'false';
	}

	public function environment()
	{
		$config = include 'app/config.php';
		return $config['environment'];
	}

	public function items()
	{
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

        return $this->items;
	}

	public function json()
	{
		return json($this->items());
	}

	public function ping($url)
	{
		exec("ping $url", $output);

		if (trim($output[8]) == 'Paquetes: enviados = 4, recibidos = 4, perdidos = 0') {
			return 'ok';
		}

		return 'error';
	}

	public function usedDiskSpace()
	{
		$diskTotalSpace = disk_total_space('/');
		$diskFreeSpace = disk_free_space('/');

		$percent = ($diskFreeSpace * 100) / $diskTotalSpace;
		$percent = number_format($percent, 2);
		$percent = $percent . '%';

		return $percent;
	}

	public function view()
	{
		$items = $this->items();
		return view('health:index', compact('items'));
	}
}
