<?php

namespace App\Models;

use Carbon\Carbon;
use DB;

trait HasVisits
{
	public $data;

	public function data($items)
	{
		foreach ($items as $key => $value) {
			$this->data[$key] = $value;
		}

		return $this;
	}

	public function ip()
	{
		$this->data['ip'] = $_SERVER['REMOTE_ADDR'];
		return $this;
	}

	public function popularAllTime()
	{
		return DB::table('visits')
			->select('*, COUNT(1) AS count')
			->limit(10)
			->orderBy('count')
			->get();
	}

	public function popularLastDays($days)
	{
		$today = new DateTime();
		$today->modify('-' . $days . 'day');

		$date = $today->format('Y-m-d');

		return DB::table('visits')
			->select('*, COUNT(1) AS count')
			->whereDate('date_create', '>=', $date)
			->limit(10)
			->orderBy('count')
			->get();
	}

	public function popularLastWeek()
	{
		$now = Carbon::now();
		$date = $now->subWeek()->format('Y-m-d');

		return DB::table('visits')
			->select('*, COUNT(1) AS count')
			->whereDate('date_create', '>=', $date)
			->limit(10)
			->orderBy('count')
			->get();
	}

	public function popularThisWeek()
	{
		$now = Carbon::now();
		$date = $now->startOfWeek()->format('Y-m-d');

		return DB::table('visits')
			->select('*, COUNT(1) AS count')
			->whereDate('date_create', '>=', $date)
			->limit(10)
			->orderBy('count')
			->get();
	}

	public function popularToday()
	{
		return DB::table('visits')
			->select('*, COUNT(1) AS count')
			->whereDate('date_create', now('Y-m-d'))
			->limit(10)
			->orderBy('count')
			->get();
	}

	public function session()
	{
		$this->data['session'] = $_SESSION;
		return $this;
	}

	public function totalVisitCount()
	{
		return DB::table('visits')
			->where('id_model', $this->id)
			->count();
	}

	public function user($user)
	{
		$this->data['user'] = $user;
		return $this;
	}

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
}
