<?php

namespace App\Models;

use DB;

trait HasVisits
{
	public $data;

	public function visit()
	{
		$data = [
			'model' => get_class($this),
			'id_model' => $this->id,
			'data' => json_encode($this->data),
			'date_create' => date('Y-m-d H:i:s'),
			'date_update' => date('Y-m-d H:i:s')
		];

		DB::table('visits')->insert($data);
	}

	public function withData($items)
	{
		foreach ($items as $key => $value) {
			$this->data[$key] = $value;
		}

		return $this;
	}

	public function withIp()
	{
		$this->data['ip'] = $_SERVER['REMOTE_ADDR'];
		return $this;
	}

	public function withSession()
	{
		$this->data['session'] = $_SESSION;
		return $this;
	}

	public function withUser($user)
	{
		$this->data['user'] = $user;
		return $this;
	}
}
