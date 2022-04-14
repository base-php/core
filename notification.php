<?php

namespace App\Models\Notifications;

class Notification
{
	public function send($users)
	{
		$users = is_iterable($users) ? $users : collect($users);
	}
}
