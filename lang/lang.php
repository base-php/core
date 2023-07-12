<?php

use Carbon\Carbon;

class Lang
{
    public static function set($lang = '')
    {
        Carbon::setLocale($_ENV['language']);

        $lang = ($lang) ? $lang : $_ENV['language'];

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/resources/lang/' . $lang)) {
            $files = scandir($_SERVER['DOCUMENT_ROOT'] . '/resources/lang/' . $lang);
            $texts = [];

            foreach ($files as $file) {
                if (strpos($file, '.php')) {
                    $key = str_replace('.php', '', $file);

                    $texts[$key] = include $_SERVER['DOCUMENT_ROOT'].'/resources/lang/' . $lang . '/' . $file;
                }
            }

            $_ENV['translate'] = $texts;
        }
    }
}
