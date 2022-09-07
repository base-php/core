<?php

namespace App\Models;

use DB;

trait Notifiable
{
	public function notifications()
	{
		$notifications = DB::table('notifications')
			->where('data->id_user', $this->id)
			->get();

		return $notifications;
	}
}
