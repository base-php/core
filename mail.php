<?php

namespace App\Mails;

class Mail
{
	public $from;
	public $subject;
	public $view;
	public $with;
	public $attach;

	public function from($from)
	{
		$this->from = $from;
		return $this;
	}

	public function subject($subject)
	{
		$this->subject = $subject;
		return $this;
	}

	public function view($view)
	{
		$this->view = $view;
		return $this;
	}

	public function with($with)
	{
		$this->with = $with;
		return $this;
	}

	public function attach($attach)
	{
		$this->attach[] = $attach;
		return $this;
	}
}
