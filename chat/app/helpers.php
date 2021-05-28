<?php

function conversations()
{
    $messages = App\Models\Chat::whereRaw('((id_sender = ' . logged('id') . ' OR id_addresse = ' . logged('id') . ')) AND (deleted != "both" AND deleted != ' . logged('id') . ')')
            ->orderBy('id', 'DESC')
        ->orderBy('id', 'DESC')
        ->get();

    $conversations = [];
    $i             = 0;

    foreach ($messages as $message) {
        if ($message->id_sender == logged('id')) {
            $user                         = App\Models\User::find($message->id_addresse);
            $conversations[$i]['id']      = $user->id;
            $conversations[$i]['name']    = $user->name;
            $conversations[$i]['photo']   = ($user->photo != '') ? $user->photo : '/resources/assets/img/app/user.png';
            $conversations[$i]['message'] = $message->content;
            $conversations[$i]['date']    = $message->date;
            $conversations[$i]['read']    = $message->read;
            $conversations[$i]['sender']  = $message->id_sender;
        } else {
            $user                         = App\Models\User::find($message->id_sender);
            $conversations[$i]['id']      = $user->id;
            $conversations[$i]['name']    = $user->name;
            $conversations[$i]['photo']   = ($user->photo != '') ? $user->photo : '/resources/assets/img/app/user.png';
            $conversations[$i]['message'] = $message->content;
            $conversations[$i]['date']    = $message->date;
            $conversations[$i]['read']    = $message->read;
            $conversations[$i]['sender']  = $message->id_sender;
        }

        $i = $i + 1;
    }

    return unique_multidim_array($conversations, 'name');
}

function unique_multidim_array($array, $key)
{
    $temp_array = array();
    $i          = 0;
    $key_array  = array();

    foreach ($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i]  = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}
