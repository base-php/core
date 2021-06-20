<?php

namespace App\Mails;

class MailName extends Mail
{
	/**
     * Create a new message instance.
     *
     * @return void
     */
	public function __construct()
	{
		
	}

	/**
     * Build the message.
     *
     * @return $this
     */
	public function build()
	{
		return $this->view('view/name');
	}
}
