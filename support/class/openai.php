<?php

class OpenAIBasePHP
{
	public $client;

	public function __construct()
	{
		if (! class_exists('OpenAI')) {
            exec('composer require openai-php/client');
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

	public function completion($prompt)
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

	public function image($data)
	{
		$response = $this->client->images()->create([
			'prompt' => $data['name'],
			'size' => $data['size']
		]);

		return $response->data[0]['url'];
	}

	public function moderation($text)
	{
		$response = $this->client->moderations()->create([
			'model' => 'text-moderation-latest',
			'input' => $text
		]);

		$result['flagged'] = $response->results[0]->flagged;
		$result['categories'] = array_keys($response->results[0]->categories);

		return $result;
	}

	public function transcribe($audio)
	{
		$response = $this->client->audio()->transcribe([
			'model' => 'whisper-1',
		    'file' => fopen($audio, 'r'),
		    'response_format' => 'verbose_json',
		]);

		$result['language'] = $response->language;
		$result['duration'] = $response->duration;
		$result['text'] = $response->text;

		return $result;
	}

	public function translate($audio)
	{
		$response = $this->client->audio()->translate([
			'model' => 'whisper-1',
			'file' => fopen($audio, 'r'),
			'response_format' => 'verbose_json'
		]);

		$result['duration'] = $response->duration;
		$result['text'] = $response->text;

		return $result;
	}
}
