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

                    $array = include $_SERVER['DOCUMENT_ROOT'].'/resources/lang/' . $lang . '/' . $file;

                    foreach ($array as $key => $value) {
                        $texts[$key] = $value;
                    }
                }
            }

            $_ENV['translate'] = $texts;
        }
    }
}
