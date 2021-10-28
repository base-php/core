<?php

use App\Models\User;

function can($module)
{
    $user = User::where('id', auth()->id)
        ->where('permissions', 'LIKE', '%' . $module . '%')
        ->get();
    if ($user->count() > 0) {
        return true;
    }
    return false;
}

function permission()
{
    $module = explode('/', $_SERVER['REQUEST_URI']);
    $user = User::where('id', auth()->id)
        ->where('permissions', 'LIKE', '%' . $module[1] . '%')
        ->get();
    if ($user->count() == 0) {
        return true;
    }
    return false;
}

function role($roles)
{
    $user = User::where('id', auth()->id)
        ->whereIn('role', $roles)
        ->get();
    if (count($user)) {
        return true;
    }
    return false;
}
