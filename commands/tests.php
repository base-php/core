<?php

// Run unit test
if (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'test') {
	system('vendor\bin\phpunit');
}
