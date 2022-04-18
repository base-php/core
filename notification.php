<?php

namespace App\Models\Notifications;

use App\Models\Notification as NotificationModel;

class Notification
{
	public function send($users)
	{
		$users = is_iterable($users) ? $users : collect($users);

		foreach ($users as $user) {
			if (in_array('database', $this->via())) {
				$this->database($user, $this->array());
			}
		}		
	}

	public function database($user, $array)
	{
		$type = get_class($this);

		$data = [
			'id_user' => $user->id
		];

		$data = array_push($data, $array);

		NotificationModel::create([
			'type'			=> $type,
			'data'			=> $data,
			'date_create'	=> now('Y-m-d H:i:s'),
			'date_update'	=> now('Y-m-d H:i:s')
		]);
	}
}
