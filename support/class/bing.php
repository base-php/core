<?php

use Fakell\Bing\Bing as API;

class Bing
{
	public $ai;
	public $tone;

	public function __construct()
	{
		$this->api = new API();
	}

	public function ask($text)
	{
		$conversation = $this->ai->createChatConversation();
		$this->params($conversation);
		return $conversation->ask(new Prompt($text));
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
