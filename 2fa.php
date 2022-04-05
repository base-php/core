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
    }

    public function key()
    {
        return $this->instance->generateSecretKey();
    }

    public function verify($code)
    {
        return $this->instace->verifyKey($this->key, $code);
    }

    public function qr($key)
    {
        return $this->instance->getQRCodeInline(
            config('application_name'),
            '',
            $key
        );
    }
}
