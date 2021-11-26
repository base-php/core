<?php

// Run static analysis
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'analyse') === 0) {
	system('vendor\bin\phpstan analyse app tests');
}
