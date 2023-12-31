<?php

class Monitor
{
	public function command($command)
	{
		$arguments = $command->getArguments();
		unset($arguments['command']);

		$content['time'] = date('Y-m-d H:i:s');
		$content['hostname'] = $this->hostname();
		$content['command'] = $command->getFirstArgument();
		$content['arguments'] = $arguments;
		$content['options'] = array_filter($command->getOptions());

		$this->register('command', $content);
	}

	public function database($logs)
	{
		array_pop($logs);

		foreach ($logs as $log) {
			$content['time'] = date('Y-m-d H:i:s');
			$content['hostname'] = $this->hostname();
			$content['duration'] = $log['time'];
			$content['query'] = $log['query'];

			$this->register('database', $content);
		}
	}

	public function email($class, $to)
	{
		$content['time'] = date('Y-m-d H:i:s');
		$content['hostname'] = $this->hostname();
		$content['class'] = get_class($class);
		$content['from'] = $class->from;
		$content['to'] = $to;
		$content['subject'] = $class->subject;

		$this->register('email', $content);
	}

	public function hostname()
	{
		return isset($_SERVER['REMOTE_ADDR']) ? gethostbyaddr($_SERVER['REMOTE_ADDR']) : '';
	}

	public function jobs($class, $queue, $status, $exception)
	{
		$content['time'] = date('Y-m-d H:i:s');
		$content['hostname'] = $this->hostname();
		$content['class'] = $class;
		$content['queue'] = $queue;
		$content['status'] = $status;
		$content['exception'] = $exception;

		$this->register('jobs', $content);
	}

	public function notification($channel, $class, $recipient)
	{
		$content['time'] = date('Y-m-d H:i:s');
		$content['hostname'] = $this->hostname();
		$content['channel'] = $channel;
		$content['class'] = get_class($class);

		if (is_class($recipient)) {
			$content['recipient_class'] = get_class($recipient);
			$content['recipient_id'] = $recipient->id;			
		} else {
			$content['recipient_email'] = $recipient;
		}

		$this->register('notification', $content);
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
		$content['hostname'] = $this->hostname();
		$content['method'] = $_SERVER['REQUEST_METHOD'];
		$content['path'] = $_SERVER['REQUEST_URI'];
		$content['status'] = http_response_code();
		$content['duration'] = $duration;
		$content['body'] = $_REQUEST;
		$content['headers'] = getallheaders();
		$content['session'] = $_SESSION;

		$this->register('request', $content);
	}
}
