<?php

use Carbon\Carbon;

/**
 * Returns text according to language.
 *
 * @param string $key
 * @return string
*/
function __(string $key): string {
	$array = explode('.', $key);

	$file = $array[0];
	$key = $array[1];

	return $_ENV['translate'][$file][$key];
}

/**
 * Register texts according to language.
 *
 * @param string $lang
 * @return void
*/
function language($lang = ''): void
{
	Carbon::setLocale($_ENV['language']);

	$lang = ($lang) ? $lang : $_ENV['language'];
	$files = scandir($_SERVER['DOCUMENT_ROOT'] . '/resources/lang/' . $lang);
	$texts = [];

	foreach ($files as $file) {
		if (strpos($file, '.php')) {
			$key = str_replace('.php', '', $file);

			$texts[$key] = include $_SERVER['DOCUMENT_ROOT'] . '/resources/lang/' . $lang . '/' . $file;
		}
	}

	$_ENV['translate'] = $texts;
}