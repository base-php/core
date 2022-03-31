<?php

use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFA
{
    // pragmarx/google2fa-qrcode & endroid/qr-code

    public $instance;

    public $key;

    public function __construct()
    {
        $this->instance = new Google2FA();
        $this->key      = auth()->two_fa;
    }

    public function verify($code)
    {
        return $this->instace->verifyKey($this->key, $code);
    }

    public function qr()
    {
        return $this->instance->getQRCodeInline(
            config('application_name'),
            '',
            $this->key
        );
    }
}
