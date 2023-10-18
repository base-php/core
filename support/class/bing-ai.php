<?php

use MaximeRenou\BingAI\BingAI as AI;
use MaximeRenou\BingAI\Chat\Prompt;
use MaximeRenou\BingAI\Chat\Tone;

class BingAI
{
	public $ai;
	public $country;
	public $image;
	public $language;

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

	public function createImages($text)
	{
		$creator = $this->ai->createImages($text);
		$this->params($creator);
		$creator->wait();

		if (! $creator->hasFailed()) {
			return $creator->getImages();
		}

		return false;
	}

	public function image($path)
	{
		$this->image = $path;
		return $this;
	}

	public function locale($language, $country)
	{
		$this->language = $language;
		$this->country = $country;
		return $this;
	}

	public function params($instance)
	{
		if ($this->image) {
			$instance->withImage($this->image);
		}

		if ($this->language && $this->country) {
			$combined = strtolower($this->language) . '-' . strtoupper($this->country);
			$instance->withPreferences($combined);
		}

		if ($this->tone) {
			$instance->withTone($this->tone);
		}
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
