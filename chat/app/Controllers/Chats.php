<?php

namespace App\Controllers;

use App\Models\Chat;
use App\Models\User;

class Chats extends Controller
{
    public function __construct()
    {
        $this->middleware('Auth');
    }

    public function index()
    {
        return view('chats/index');
    }

    public function messages($id)
    {
        $messages = Chat::whereRaw('((id_sender = ' . logged('id') . ' AND id_addresse = ' . $id . ') OR (id_addresse = ' . logged('id') . ' AND id_sender = ' . $id . ')) AND (deleted != "both" AND deleted != ' . logged('id') . ')')
            ->orderBy('id', 'DESC')
            ->get();

        Chat::whereRaw('((id_sender = ' . logged('id') . ' AND id_addresse = ' . $id . ') OR (id_addresse = ' . logged('id') . ' AND id_sender = ' . $id . ')) AND (deleted != "both" AND deleted != ' . logged('id') . ')')
            ->update(['read' => 1]);

        return $messages;
    }

    public function send()
    {
        $message = Chat::create([
            'id_addresse' => post('id_addresse'),
            'id_sender'   => logged('id'),
            'content'     => post('content'),
            'date'        => time(),
            'timestamp'   => time(),
            'read'        => 0,
            'receive'     => 0,
        ]);

        return $message;
    }

    public function receive()
    {
        $messages = Chat::where('id_addresse', logged('id'))
            ->where('receive', 0)
            ->get();

        Chat::where('id_addresse', logged('id'))
            ->where('receive', 0)
            ->update(['receive' => 1]);

        $result = [];
        $i      = 0;

        foreach ($messages as $message) {
            $user = User::find($message->id_sender);

            $result[$i]['name']      = $user->name;
            $result[$i]['photo']     = $user->photo;
            $result[$i]['id_sender'] = $message->id_sender;
            $result[$i]['timestamp'] = $message->timestamp;
            $result[$i]['date']      = $message->date;
            $result[$i]['content']   = $message->content;
        }

        return $result;
    }

    public function read($id)
    {
        $messages = Chat::where('id_addresse', logged('id'))
            ->where('id_sender', $id)
            ->where('read', 0)
            ->update(['read' => 1]);
    }

    public function users()
    {
        $users = User::where('name', 'LIKE', '%' . get('user') . '%')
            ->where('id', '!=', logged('id'))
            ->get();
        return $users;
    }

    public function conversation($id)
    {
        $messages = Chat::whereRaw('(id_sender = ' . logged('id') . ' AND id_addresse = ' . $id . ') OR (id_addresse = ' . logged('id') . ' AND id_sender = ' . $id . ')')->get();

        foreach ($messages as $message) {
            if ($message->deleted == '') {
                $message->update(['deleted' => logged('id')]);
            } else {
                $message->update(['deleted' => 'both']);
            }
        }
    }

    public function message($timestamp)
    {
        $message = Chat::where('timestamp', $timestamp)->first();

        if ($message->deleted == '') {
            $message->update(['deleted' => logged('id')]);
        } else {
            $message->update(['deleted' => 'both']);
        }
    }

    public function file()
    {
        $file = files()->input('file')
            ->upload('resources/assets/chat');

        $content = 'Archivo: <a style="color: white" href="/resources/assets/chat/' . $file->filename . '">' . $file->filename . '</a>';

        $message = Chat::create([
            'id_addresse' => post('id_addresse'),
            'id_sender'   => logged('id'),
            'content'     => $content,
            'date'        => time(),
            'timestamp'   => time(),
            'read'        => 0,
            'receive'     => 0,
        ]);

        return $message;
    }
}
