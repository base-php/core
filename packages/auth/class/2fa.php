<?php

use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFA
{
    // pragmarx/google2fa-qrcode & endroid/qr-code

    public $instance;

    public function __construct()
    {
        $this->instance = new Google2FA();
    }

    public function key()
    {
        return $this->instance->generateSecretKey();
    }

    public function verify()
    {
        $verify = $this->instance->verifyKey(auth()->two_fa, request('code'));

        if ($verify) {
            session('2fa', auth()->two_fa);
            $redirect = request('redirect') ? request('redirect') : $auth->redirect_login;

            return redirect($redirect);
        }

        return redirect(server('referer'))->with('error', lang('Incorrect code'));
    }

    public function qr($key)
    {
        return $this->instance->getQRCodeInline(
            config('application_name'),
            auth()->email,
            $key
        );
    }
}
