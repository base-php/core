<?php

function qr($config)
{
    return QRcode::png($config['data'], $config['file'] . '.png', 'L', 10, 2);
}
