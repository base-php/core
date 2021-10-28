<?php

use App\Models\User;

/**
* Get a session var.
*
* @param  User\bool
*/
function auth(): User|bool {
    if (isset($_SESSION['id'])) {
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        } else {
            $user = User::find($_SESSION['id']);
            $_SESSION['user'] = $user;
        }

        return $user;
    }

    return false;
}

/**
* Send email for reset password.
*
* @return Redirect
*/
function forgot(): Redirect
{
    if (post()) {
        $user = User::where('email', request('email'))->first();

        if (!$user) {
            return redirect('/forgot-password')->with('error', __('auth.email_not_match'));
        }

        email($user->email, new App\Mails\PasswordRecovery($user));

        return redirect('/forgot-password')->with('info', __('auth.check_email'));
    }
}

/**
* Login a session.
*
* @param array $user
* @return Redirect|null
*/
function login(array $user): Redirect|null
{
    $user = User::where('email', $user['email'])
        ->where('password', md5($user['password']))
        ->whereNull('oauth')
        ->first();

    if ($user) {
        $_SESSION['id'] = $user->id;

        return redirect('/dashboard');
    }

    return redirect('/login')->with('error', __('auth.incorrect_data'));
}

/**
* Logout session.
*
* @return void
*/
function logout(): void
{
    session_destroy();
}

/**
* Recover password.
*
* @return Redirect
*/
function recover(): Redirect
{
    if (post()) {
        $user = User::where('hash', request('id'))->first();

        if (!$user) {
            return redirect('/login')->with('error', __('auth.link_invalid'));
        }

        if (request('password') != request('confirm_password')) {
            return redirect('/recover/' . request('id'))->with('error', 'Las contraseñas no coinciden.');
        }

        $user->password = md5(request('password'));
        $user->save();

        return redirect('/login')->with('info', __('auth.password_not_match'));
    }
}

/**
* Register new user.
*
* @param  array $user
* @return Redirect
*/
function register(array $user): Redirect
{
    $email = User::where('email', $user['email'])->get();

    if ($email->count() > 0) {
        return redirect('/register')->with('error', __('auth.email_verified_error'));
    }

    if ($user['password'] != $user['confirm_password']) {
        return redirect('/register')->with('error', __('auth.password_not_match'));
    }

    $user = User::create([
        'name'          => $user['name'],
        'email'         => $user['email'],
        'password'      => md5($user['password']),
        'date_create'   => date('Y-m-d H:i:s'),
        'date_update'   => date('Y-m-d H:i:s')
    ]);

    $user->update(['hash' => md5($user->id)]);

    return redirect('/login')->with('info', __('auth.register_success'));
}
