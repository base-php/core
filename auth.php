<?php

use App\Mails\PasswordRecovery;
use App\Models\User;

function auth() {
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

function forgot()
{
    if (post()) {
        $user = User::where('email', request('email'))->first();

        if (!$user) {
            return redirect('/forgot-password')->with('error', __('auth.email_not_match'));
        }

        email($user->email, new PasswordRecovery($user));

        return redirect('/forgot-password')->with('info', __('auth.check_email'));
    }
}

function login($user)
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

function logout()
{
    session_destroy();
}

function recover()
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

function register($user)
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
