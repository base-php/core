<?php

use Fakell\Bing\Bing as API;
use Fakell\Bing\Constant\Tones;

class Bing
{
	public $api;
	public $tone;

	public function __construct()
	{
		$this->api = new API();
	}

	public function ask($text)
	{
		$this->api->ask($text, $this->tone);
		return $this->api->getResponse();
	}

	public function tone($tone)
	{
		if ($tone == 'balanced') {
			$this->tone = Tones::BALANCED;
		}

		if ($tone == 'creative') {
			$this->tone = Tones::CREATIVE;
		}

		if ($tone == 'precise') {
			$this->tone = Tones::PRECISE;
		}

		return $this;
	}
}
