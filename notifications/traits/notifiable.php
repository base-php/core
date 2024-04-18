<?php

namespace App\Models;

use DB;

trait Notifiable
{
    public function markAsRead()
    {
        $now = now('Y-m-d h:i:s');

        DB::table('notifications')
            ->whereNull('date_read')
            ->update(['date_read' => $now]);
    }

    public function notifications()
    {
        $notifications = DB::table('notifications')
            ->where('user_id', $this->id)
            ->get();

        return $notifications;
    }

    public function notify($class)
    {
        $class->send($this);
    }

    public function unreadNotifications()
    {
        $notifications = DB::table('notifications')
            ->where('user_id', $this->id)
            ->whereNull('date_read')
            ->get();

        return $notifications;
    }
}
