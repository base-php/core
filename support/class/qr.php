<?php

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class QR
{
    public $data;

    public $result;

    public function __construct()
    {
        if (! class_exists('Endroid\QrCode\Builder\Builder')) {
            throw new Exception("Please execute 'composer require endroid/qr-code' in console.");
        }
    }

    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    public function generate()
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($this->data)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->build();

        $this->result = $result;

        return $this;
    }

    public function save($path)
    {
        return $this->result->saveToFile($_SERVER['DOCUMENT_ROOT'].'/'.$path);
    }

    public function url()
    {
        return $dataUri = $this->result->getDataUri();
    }
}
