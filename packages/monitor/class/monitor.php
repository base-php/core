<?php

class Monitor
{
	public function request($duration)
	{
		$data['time'] = date('Y-m-d H:i:s');
		$data['hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$data['method'] = $_SERVER['REQUEST_METHOD'];
		$data['path'] = $_SERVER['SCRIPT_NAME'];
		$data['status'] = http_response_code();
		$data['duration'] = $duration;
		$data['payload'] = $_REQUEST;
		$data['headers'] = getallheaders();
		$data['session'] = $_SESSION;

		$data = json($data);

		DB::table('monitor')->insert($data);
	}
}
