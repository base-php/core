<?php

class Health
{
	public function cpuUsage($min)
	{
		if ($min == 1) {
			$index = 0;
		}

		if ($min == 5) {
			$index = 1;
		}

		if ($min == 15) {
			$index = 2;
		}

		$cpuUsage = sys_getloadavg()[$index] * 100;
		return $cpuUsage;
	}

	public function databaseConnection($connection = 'default')
	{
		try {
			DB::connection($connection)->getPDO();
			return 'Ok';
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

		$result = DB::select(
			DB::raw($sql)
		);

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

		$result = DB::select(
			DB::raw($sql)
		);

        $size = number_format((float) $result[0]->size, 2, '.', '');
        return $size;
	}

	public function debug()
	{
		return config('errors');
	}

	public function environment()
	{
		return config('environment');
	}

	public function ping($url)
	{
		exec("ping $url", $output);

		if (trim($output[8]) == 'Paquetes: enviados = 4, recibidos = 4, perdidos = 0') {
			return 'success';
		}

		return 'error';
	}

	public function securityAdvisoriesPackages()
	{
		exec('composer audit --format=plain', $output);

		if (trim($output[1]) == 'No security vulnerability advisories found') {
			return 'Ok';
		}

		return trim($output[1]);
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
		$i = 0;

		if (strposToArray('cpuUsage', config('health'))) {
			$i = strposToArray('cpuUsage', config('health'));
			$item = config('health')[$i];

			$explode = explode(':', $item);
			$param = $explode[1];

			$items[$i]['title'] = 'Uso de CPU';
			$items[$i]['content'] = $this->cpuUsage($param);

			$percent = str_replace('%', '', $this->cpuUsage($param));

			if ($percent > 70) {
				$items[$i]['danger'] = true;
			}

			$i++;
		}

		if (in_array('environment', config('health'))) {
			$items[$i]['title'] = 'Entorno';
			$items[$i]['content'] = $this->environment();

			if ($this->environment() != 'production') {
				$items[$i]['danger'] = true;
			}

			$i++;
		}

		if (in_array('debug', config('health'))) {
			$items[$i]['title'] = 'Debug';
			$items[$i]['content'] = $this->debug();

			if ($this->debug()) {
				$items[$i]['danger'] = true;
			}

			$i++;
		}

		$items = (object) $items;

		return view('health:index', compact('items'));
	}
}
