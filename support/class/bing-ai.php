<?php

use MaximeRenou\BingAI\BingAI;
use MaximeRenou\BingAI\Chat\Prompt;

class BingAI
{
	public $ai;
	public $image;

	public function __construct()
	{
		$this->ai = new BingAI(config('bing_cookie'));
	}

	public function ask($text)
	{
		$conversation = $this->ai->createChatConversation();
		$prompt = new Prompt($text);

		if ($this->withImage) {
			$prompt->withImage($this->image);
		}

		return $conversation->ask($prompt);
	}

	public function withImage($path)
	{
		$this->image = $path;
		return $this;
	}
}
