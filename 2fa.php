<?php

use Endroid\QrCode\QrCode;
use PragmaRX\Google2FA\Google2FA;

class TwoFA
{
    // endroid/qr-code
    // pragmarx/google2fa-qrcode

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

    public function qr($size)
    {
        $value = $this->instance->getQRCodeUrl(
            config('application_name'),
            '',
            $this->key
        );

        $qr = new QrCode($value);
        $qr->setSize($size);

        $url = $qr->writeDataUri();

        return $url;
    }
}
