<?php

namespace App\Notifications;

use App\Models\Notification as NotificationModel;

class Notification
{
	public function send($users)
	{
       $users = is_iterable($users) ? $users : collect([$users]);

		foreach ($users as $user) {
			if (in_array('database', $this->via())) {
				$this->database($user, $this->array());
			}

            if (in_array('email', $this->via())) {
                email($user->email, $this->email());
            }
		}		
	}

	public function database($user, $array)
	{
		$type = get_class($this);

		$data = [
			'id_user' => $user->id
		];

		foreach ($array as $key => $value) {
            $data[$key] = $value;
        }

		NotificationModel::create([
			'type'			=> $type,
			'data'			=> $data,
			'date_create'	=> now('Y-m-d H:i:s'),
			'date_update'	=> now('Y-m-d H:i:s')
		]);
	}
}
