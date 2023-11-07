<?php

class Monitor
{
	public function request($duration)
	{
		$content['time'] = date('Y-m-d H:i:s');
		$content['hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$content['method'] = $_SERVER['REQUEST_METHOD'];
		$content['path'] = $_SERVER['SCRIPT_NAME'];
		$content['status'] = http_response_code();
		$content['duration'] = $duration;
		$content['payload'] = $_REQUEST;
		$content['headers'] = getallheaders();
		$content['session'] = $_SESSION;

		$content = json($content);

		$data = [
			'type' => 'request',
			'content' => $content
		];

		DB::table('monitor')->insert($data);
	}

	public function email($class, $to)
	{
		$content['time'] = date('Y-m-d H:i:s');
		$content['hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$content['class'] = get_class($class);
		$content['from'] = $class->from;
		$content['to'] = $to;
		$content['subject'] = $class->subject;

		$data = [
			'type' => 'email',
			'content' => $content
		];

		$data = json($data);
	}
}
