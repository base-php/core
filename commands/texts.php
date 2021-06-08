<?php

function line_break($param = 1)
{
	for ($i = 1; $i <= $param; $i++) {
		echo "\n";
	}
}

function normal($text)
{
	return $text;
}

function success($text)
{
	return "\e[0;32m$text\e[0m";
}

function danger($text)
{
	return "\e[1;31m$text\e[0m";
}

function warning($text)
{
	return "\e[1;33m$text\e[0m";
}
