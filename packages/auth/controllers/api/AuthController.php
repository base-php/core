<?php

namespace App\Controllers;

use App\Mails\PasswordRecoveryEmail;
use App\Mails\VerifiedEmail;
use App\Models\User;
use Facebook;
use Google;
use Response;

class AuthController extends Controller
{
    /**
     * Model to use for auth.
     * 
     * @var class
     */
    public $model = User::class;

    /**
     * Turn email verification on or off.
     *
     * @var string
     */
    public $verified_email = false;

    /**
     * Register a user.
     *
     * @return View|Redirect
     */
    public function register(): Response
    {
        $email = (new $this->model)->where('email', request('email'))->get();

        if ($email->count() > 0) {
            return response()->json(['error' => lang('auth.email_verified_error')], 401);
        }

        if (request('password') != request('confirm_password')) {
            return response()->json(['error' => lang('auth.password_not_match')], 401);
        }

        $user = (new $this->model)->create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => encrypt(request('password')),
            'date_create' => now('Y-m-d H:i:s'),
            'date_update' => now('Y-m-d H:i:s'),
        ]);

        $user->update(['hash' => encrypt($user->id)]);

        if ($this->verified_email) {
            email($user->email, new VerifiedEmail($user));
        }

        return response()->json(['info' => lang('auth.register_success')]);
    }

    /**
     * Login user.
     *
     * @return Response
     */
    public function login(): Response
    {
        if (request('google')) {
            return google()->login();
        }

        if (request('facebook')) {
            return facebook()->login();
        }

        $user = (new $this->model)->where('email', request('email'))
            ->where('password', encrypt(request('password')))
            ->whereNull('oauth')
            ->first();

        if ($user) {
            if ($this->verified_email && ! $user->date_verified_email) {
                return response()->json(['error' => lang('auth.verified_email')], 401);
            }

            $sessions = json($user->sessions ?? '[]');

            $i = count($sessions);

            $sessions[$i]['id'] = phpsessid();
            $sessions[$i]['device'] = server('user_agent');
            $sessions[$i]['datetime'] = now('Y-m-d H:i:s');

            $user->update(['sessions' => json($sessions)]);

            session('id', $user->id);
            $redirect = request('redirect') ? request('redirect') : $this->redirect_login;
            return response()->json(['redirect' => $redirect]);
        }

        return response()->json(['error' => lang('auth.incorrect_data')], 401);
    }

    /**
     * Verified email
     *
     * @param string $hash
     * @return Response
     */
    public function verifiedEmail(string $hash): Response
    {
        $user = (new $this->model)->where('hash', $hash)->first();

        if (! $user) {
            return response()->json(['error' => lang('auth.error_hash')], 401);   
        }

        (new $this->model)->where('hash', $hash)->update(['date_verified_email' => now('Y-m-d H:i:s')]);

        return response()->json(['info' => lang('auth.email_verified_success')]);
    }

    /**
     * Process forgot password form.
     *
     * @return Response
     */
    public function forgotPassword(): Response
    {
        $user = (new $this->model)->where('email', request('email'))->first();

        if (! $user) {
            return response()->json(['error' => lang('auth.email_not_match')], 401);
        }

        email($user->email, new PasswordRecoveryEmail($user));

        return response()->json(['info' => lang('auth.check_email')]);
    }

    /**
     * Process recover password form.
     *
     * @param  string  $id
     * @return Response
     */
    public function recover(string $id): Response
    {
        $user = (new $this->model)->where('hash', request('id'))->first();

        if (! $user) {
            return response()->json(['error' => lang('auth.link_invalid')], 401);
        }

        if (request('password') != request('confirm_password')) {
            return response()->json(['error' => 'Las contraseñas no coinciden.'], 401);
        }

        $user->password = encrypt(request('password'));
        $user->save();

        return response()->json(['info' => lang('auth.password_not_match')]);
    }

    /**
     * Process 2fa form.
     *
     * @param  string  $id
     */
    public function twoFa(string $id)
    {
        $two_fa = new TwoFA;
        return $two_fa->verify();
    }

    /**
     * Logout user.
     *
     * @return void
     */
    public function logout(): void
    {
        $user = (new $this->model)->find(auth()->id);

        $sessions = json($user->sessions);

        $i = array_search(phpsessid, array_column($sessions, 'id'));

        unset($sessions[$i]);

        $user->update([
            'sessions' => $sessions
        ]);

        session()->delete();
    }
}
