<?php

namespace App\Controllers;

use App\Mails\PasswordRecoveryEmail;
use App\Mails\VerifiedEmail;
use App\Models\User;
use Facebook;
use Google;
use Redirect;
use View;

class AuthController extends Controller
{
    /**
     * Model to use for auth.
     * 
     * @var class
     */
    public $model = User::class;

    /**
     * Where the user will be redirected when they log in.
     *
     * @var string
     */
    public $redirect_login = '/dashboard';

    /**
     * Turn email verification on or off.
     *
     * @var string
     */
    public $verified_email = false;

    /**
     * Show login form.
     *
     * @return View
     */
    public function index(): View
    {
        return view('auth.login');
    }

    /**
     * Show register form.
     *
     * @return View|Redirect
     */
    public function register(): View|Redirect
    {
        if (post()) {
            $email = (new $this->model)->where('email', request('email'))->get();

            if ($email->count() > 0) {
                return redirect('/register')->with('error', lang('Email is already registered.'));
            }

            if (request('password') != request('confirm_password')) {
                return redirect('/register')->with('error', lang('Passwords do not match.'));
            }

            $user = (new $this->model)->create([
                'name' => request('name'),
                'email' => request('email'),
                'password' => encrypt(request('password'))
            ]);

            $user->update(['hash' => encrypt($user->id)]);

            if ($this->verified_email) {
                email($user->email, new VerifiedEmail($user));
            }

            return redirect('/login')->with('info', lang('Registered user, now you can log in.'));
        }

        return view('auth.register');
    }

    /**
     * Login user.
     *
     * @return Redirect
     */
    public function login(): Redirect
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
                return redirect('/login')->with('error', lang('In order to log in you must verify your email first.'));
            }

            $sessions = json($user->sessions ?? '[]');

            $i = count($sessions);

            $sessions[$i]['id'] = phpsessid();
            $sessions[$i]['device'] = os();
            $sessions[$i]['ip'] = server('ip_visitor');
            $sessions[$i]['datetime'] = now('Y-m-d H:i:s');

            $user->update(['sessions' => json($sessions)]);

            session('id', $user->id);

            if ($user->two_fa) {
                session('2fa', $user->two_fa);
            }

            $redirect = request('redirect') ? request('redirect') : $this->redirect_login;
            return redirect($redirect);
        }

        return redirect('/login')->with('error', lang('Incorrect data'));
    }

    /**
     * Verified email
     *
     * @param string $hash
     * @return Redirect
     */
    public function verifiedEmail(string $hash): Redirect
    {
        $user = (new $this->model)->where('hash', $hash)->first();

        if (! $user) {
            return redirect('/login')->with('error', lang('Error verifying email'));            
        }

        (new $this->model)->where('hash', $hash)->update(['date_verified_email' => now('Y-m-d H:i:s')]);

        return redirect('/login')->with('info', lang('Email verified successfully, now you can login.'));
    }

    /**
     * Login user with Facebook account.
     *
     * @return Facebook
     */
    public function facebook(): ?Facebook
    {
        return facebook()->login();
    }

    /**
     * Login user with Google account.
     *
     * @return Google
     */
    public function google(): ?Google
    {
        return google()->login();
    }

    /**
     * Show and process forgot password form.
     *
     * @return View|Redirect
     */
    public function forgotPassword(): View|Redirect
    {
        if (post()) {
            $user = (new $this->model)->where('email', request('email'))->first();

            if (! $user) {
                return redirect('/forgot-password')->with('error', lang('We can\'t find a user with that email address.'));
            }

            email($user->email, new PasswordRecoveryEmail($user));

            return redirect('/forgot-password')->with('info', lang('Check your email to recover your password.'));
        }

        return view('auth.forgot-password');
    }

    /**
     * Show and process recover password form.
     *
     * @param  string  $id
     * @return View|Redirect
     */
    public function recover(string $id): View|Redirect
    {
        if (post()) {
            $user = (new $this->model)->where('hash', request('id'))->first();

            if (! $user) {
                return redirect('/login')->with('error', lang('Invalid password recovery link.'));
            }

            if (request('password') != request('confirm_password')) {
                return redirect('/recover/' . request('id'))->with('error', 'Las contraseñas no coinciden.');
            }

            $user->password = encrypt(request('password'));
            $user->save();

            return redirect('/login')->with('info', lang('auth.password_not_match'));
        }

        return view('auth.recover', compact('id'));
    }

    /**
     * Show and process 2fa form.
     *
     * @param  string  $id
     * @return View|Redirect
     */
    public function twoFa(string $id): View|Redirect
    {
        if (post()) {
            $two_fa = new TwoFA;

            return $two_fa->verify();
        }

        return view('auth.2fa', compact('id'));
    }

    /**
     * Logout user.
     *
     * @return Redirect
     */
    public function logout(): Redirect
    {
        session()->delete();

        return redirect('/login');
    }
}
