<?php

use App\Controllers\AuthController;
use App\Mails\PasswordRecoveryEmail;
use App\Models\User;

class Auth
{
    public static function forgot()
    {
        if (post()) {
            $user = User::where('email', request('email'))->first();

            if (!$user) {
                return redirect('/forgot-password')->with('error', lang('auth.email_not_match'));
            }

            email($user->email, new PasswordRecoveryEmail($user));

            return redirect('/forgot-password')->with('info', lang('auth.check_email'));
        }
    }

    public static function login($user)
    {
        $auth = new AuthController();

        $user = User::where('email', $user['email'])
            ->where('password', encrypt($user['password']))
            ->whereNull('oauth')
            ->first();

        if ($user) {
            $_SESSION['id'] = $user->id;

            $redirect = (isset($user['redirect'])) ? $user['redirect'] : $auth->redirect_login;

            return redirect($redirect);
        }

        return redirect('/login')->with('error', lang('auth.incorrect_data'));
    }

    public static function logout()
    {
        session_destroy();
    }

    public static function recover()
    {
        if (post()) {
            $user = User::where('hash', request('id'))->first();

            if (!$user) {
                return redirect('/login')->with('error', lang('auth.link_invalid'));
            }

            if (request('password') != request('confirm_password')) {
                return redirect('/recover/' . request('id'))->with('error', 'Las contraseñas no coinciden.');
            }

            $user->password = encrypt(request('password'));
            $user->save();

            return redirect('/login')->with('info', lang('auth.password_not_match'));
        }
    }

    public static function register($user)
    {
        $email = User::where('email', $user['email'])->get();

        if ($email->count() > 0) {
            return redirect('/register')->with('error', lang('auth.email_verified_error'));
        }

        if ($user['password'] != $user['confirm_password']) {
            return redirect('/register')->with('error', lang('auth.password_not_match'));
        }

        $user = User::create([
            'name'          => $user['name'],
            'email'         => $user['email'],
            'password'      => encrypt($user['password']),
            'date_create'   => date('Y-m-d H:i:s'),
            'date_update'   => date('Y-m-d H:i:s')
        ]);

        $user->update(['hash' => encrypt($user->id)]);

        return redirect('/login')->with('info', lang('auth.register_success'));
    }
}
