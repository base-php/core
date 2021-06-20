<?php

namespace App\Mails;

class MailName extends Mail
{
	/**
	 * Set from for email.
	 * 
	 * @var string $from
	 */
	public $from = '';

	/**
	 * Set subject for email.
	 * 
	 * @var string $subject
	 */
	public $subject = '';

	/**
	 * Set attach for email.
	 * 
	 * @var array $attach
	 */
	public $attach = [];

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
		return $this->view();
	}
}
