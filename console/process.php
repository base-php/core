<?php

header('Access-Control-Allow-Origin: *');

$fopen = fopen('result.php', 'w');

fwrite($fopen, $_POST['value']);

include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

include 'result.php';