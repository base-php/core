<?php

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

class Gemini
{
	public function chat($text)
	{
		if (! class_exists('GeminiAPI\Client')) {
			throw new Exception('Please execute `composer require gemini-api-php/client`');
		}

		$client = new Client(config('gemini_api_key'));
		$chat = $client->geminiPro()->startChat();

		$response = $chat->sendMessage(new TextPart($text));
		return $response->text();
	}
}
