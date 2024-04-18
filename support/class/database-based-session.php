<?php

class DatabaseBasedSession
{
	public $id;
	public $query;

	public function __construct()
	{
		$this->clear();
		$this->id = $_COOKIE['PHPSESSID'];
		$this->query = DB::table('sessions')->where('session_id', $this->id);
	}

	public function all()
	{
		return $this->query->get();
	}

	public function clear()
	{
		$session_lifetime = config('session_lifetime') ?? 1440;
		$sessions = DB::table('sessions')->get();

		foreach ($sessions as $session) {
			$strtotime = strtotime($session->date_update);
			
			$date_update = $strtotime + $session_lifetime;
			$date_update = date('Y-m-d H:i:s', $date_update);

			if ($date_update <= date('Y-m-d H:i:s')) {
				DB::table('sessions')
					->where('id', $session->id)
					->delete();
			}
		}
	}

	public function delete($key = '')
	{
		if ($key) {
			$this->query->where('key', $key)->delete();
			return;
		}

		$this->query->delete();
	}

	public function flash($key, $value)
	{
		$key = 'basephp-flash.' . $key;
		$this->set($key, $value);
	}

	public function get($key)
	{
		$row = $this->query->where('key', $key)->first();
		return $row->value ?? null;
	}

	public function set($key, $value)
	{
		DB::table('sessions')
			->insert([
				'session_id' => $this->id,
				'key' => $key,
				'value' => $value
			]);

		return $value;
	}
}
