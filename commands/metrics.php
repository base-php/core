<?php

// Create controllers
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'metrics') === 0) {
	system('php vendor\bin\phpmetrics --report-html=phpmetrics app');
}
