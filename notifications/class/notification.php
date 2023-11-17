<?php

namespace App\Notifications;

use DB;

class Notification
{
    public function send($users)
    {
        $users = is_iterable($users) ? $users : collect([$users]);

        foreach ($users as $user) {
            foreach ($this->via() as $via) {
                if ($via == 'database') {
                    $this->database($user, $this->array());
                    $monitor->notification($via, $this, $user);
                }

                if ($via == 'email') {
                    email($user->email, $this->email());
                    $monitor->notification($via, $this, $user->email);
                }

                if ($via != 'database' && $via != 'email') {
                    $this->$via();
                    $monitor->notification($via, $this, $user);
                }
            }
        }
    }

    public function database($user, $array)
    {
        $type = get_class($this);

        $data = [
            'id_user' => $user->id,
        ];

        foreach ($array as $key => $value) {
            $data[$key] = $value;
        }

        DB::table('notifications')->insert([
            'type' => $type,
            'data' => $data
        ]);
    }
}
