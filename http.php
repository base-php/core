<?php

use GuzzleHttp\Client;

/**
 * Client for HTTP requests, require guzzlehttp/guzzle package.
 */
class HTTP
{
	/**
	 * Body of the request response.
	 */
	public $body;

	/**
	 * GET request.
	 *
	 * @param $url string
	 * @param $data array
	 * @return HTTP
	 */
	public static function get($url, $data = [])
	{
		$client = new Client();

		if (empty($data)) {
			$response = $client->request('GET', $url);
		} else {
			$response = $client->request('GET', $url, [
				'query' => $data
			]);
		}

		$class = new static();
		return $response->getBody();
	}

	/**
	 * POST request.
	 *
	 * @param $url string
	 * @param $data array
	 * @return HTTP
	 */
	public static function post($url, $data = [])
	{
		$client = new Client();

		if (empty($data)) {
			$response = $client->request('POST', $url);
		} else {
			$response = $client->request('POST', $url, [
				'form_params' => $data
			]);
		}

		$class = new static();
		return $response->getBody();
	}
}
