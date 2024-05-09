<?php

use MaximeRenou\BingAI\BingAI as AI;
use MaximeRenou\BingAI\Chat\Prompt;
use MaximeRenou\BingAI\Chat\Tone;

class BingAI
{
	public $ai;
	public $tone;

	public function __construct()
	{
		$this->ai = new AI(config('bing_cookie'));
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
