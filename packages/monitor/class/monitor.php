<?php

class Monitor
{
	public function email($class, $to)
	{
		$content['time'] = date('Y-m-d H:i:s');
		$content['hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$content['class'] = get_class($class);
		$content['from'] = $class->from;
		$content['to'] = $to;
		$content['subject'] = $class->subject;

		$this->register('email', $content);
	}

	public function command($command)
	{
		$arguments = $command->getArguments();
		unset($arguments['command']);

		$content['time'] = date('Y-m-d H:i:s');
		$content['hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$content['command'] = $command->getFirstArgument();
		$content['arguments'] = $arguments;
		$content['options'] = array_filter($command->getOptions());

		$this->register('command', $content);
	}

	public function register($type, $content)
	{
		$content = json($content);

		$data = [
			'type' => $type,
			'content' => $content
		];

		DB::table('monitor')->insert($data);
	}

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

		$this->register('request', $content);
	}
}
