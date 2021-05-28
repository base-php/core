<?php

/**
 * Generate QR code, require kairos/phpqrcode package.
 *
 * @param  array $config
 * @return QRCode
 */
function qr($config)
{
    return QRcode::png($config['data'], $config['file'] . '.png', 'L', 10, 2);
}
