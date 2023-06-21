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
		return view('health:index', compact('items'));
	}
}
