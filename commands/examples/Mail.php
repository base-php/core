<?php

namespace App\Mails;

use View;

class MailName extends Mail
{
    /**
    * Set from for email.
    * 
    * @var string $from
    */
    public string $from = '';

    /**
    * Set subject for email.
    * 
    * @var string $subject
    */
    public string $subject = '';

    /**
    * Set attach for email.
    * 
    * @var array $attach
    */
    public array $attach = [];

    /**
    * Create a email instance.
    *
    * @return void
    */
    public function __construct()
    {

    }

    /**
    * Build the email.
    *
    * @return View
    */
    public function build(): View
    {
        return view();
    }
}
