<?php

class DatabaseBasedSession
{
	public $id;
	public $query;

	public function __construct()
	{
		$this->id = $_SESSION['PHPSESSID'];
		$this->query = DB::table('sessions')->where('id_session', $this->id);
	}

	public function all()
	{
		return $this->query->get();
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
		return $row->$key ?? null;
	}

	public function set($key, $value)
	{
		DB::table('sessions')
			->insert([
				'id_session' => $this->id,
				'key' => $key,
				'value' => $value
			]);

		return $key;
	}
}
