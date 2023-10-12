<?php

use MaximeRenou\BingAI\BingAI;
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
		$this->ai = new BingAI(config('bing_cookie'));
	}

	public function ask($text)
	{
		$conversation = $this->ai->createChatConversation();

		if ($this->image) {
			$conversation->withImage($this->image);
		}

		if ($this->language && $this->country) {
			$combined = strtolower($this->language) . '-' . strtoupper($this->country);
			$conversation->withPreferences($combined);
		}

		if ($this->tone) {
			$conversation->withTone($this->tone);
		}

		return $conversation->ask(new Prompt($text));
	}

	public function createImages($text)
	{
		$creator = $this->ai->createImages($text);

		if ($this->image) {
			$creator->withImage($this->image);
		}

		if ($this->language && $this->country) {
			$combined = strtolower($this->language) . '-' . strtoupper($this->country);
			$creator->withPreferences($combined);
		}

		if ($this->tone) {
			$creator->withTone($this->tone);
		}

		$creator->wait();

		if (! $creator->hasFailed()) {
			return $creator->getImages();
		}

		return false;
	}

	public function locale($language, $country)
	{
		$this->language = $language;
		$this->country = $country;
		return $this;
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

	public function image($path)
	{
		$this->image = $path;
		return $this;
	}
}
