<?php

class OpenAIBasePHP
{
	public $client;

	public function __construct()
	{
		if (! class_exists('OpenAI')) {
            throw new Exception("Please execute 'composer require openai-php/client' in console.")
        }

		$this->client = OpenAI::client(config('openai-api-key'));
	}

	// league/commonmark
	public function chat($content)
	{
		$response = $this->client->chat()->create([
			'model' => 'gpt-3.5-turbo',
			'messages' => [
				['role' => 'user', 'content' => $content]
			]
		]);

		return str()->markdown($response['choices'][0]['message']['content']);
	}

	public function completions($prompt)
	{
		$result = $this->client->completions()->create([
			'model' => 'text-davinci-003',
			'prompt' => $prompt
		]);

		return $result['choices'][0]['text'];
	}

	public function custom($input, $instruction)
	{
		$response = $this->client->edits()->create([
			'model' => 'text-davinci-edit-001',
			'input' => $input,
			'instruction' => $instruction
		]);

		return $response['choices'][0]['text'];
	}
}
