<?php

/**
 * Verify if user can vie module in menu.
 *
 * @return boolean
 */
function can($module)
{
    $user = App\Models\User::where('id', auth()->id)
        ->where('permissions', 'LIKE', '%' . $module . '%')
        ->get();
    if ($user->count() > 0) {
        return true;
    }
    return false;
}

/**
 * Verify if user can access module.
 *
 * @return boolean
 */
function permission()
{
    $module = explode('/', $_SERVER['REQUEST_URI']);
    $user = App\Models\User::where('id', auth()->id)
        ->where('permissions', 'LIKE', '%' . $module[1] . '%')
        ->get();
    if ($user->count() == 0) {
        return true;
    }
    return false;
}

/**
 * Verify if roles can access module.
 *
 * @param array $roles
 * @return boolean
 */
function role($roles)
{
    $user = App\Models\User::where('id', auth()->id)
        ->whereIn('role', $roles)
        ->get();
    if (count($user)) {
        return true;
    }
    return false;
}
