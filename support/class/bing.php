<?php

use Fakell\Bing\Bing as API;

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
			$this->tone = Tone::Balanced;
		}

		if ($tone == 'creative') {
			$this->tone = Tone::Creative;
		}

		if ($tone == 'precise') {
			$this->tone = Tone::Precise;
		}

		return $this;
	}
}
