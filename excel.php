<?php

namespace App\Excel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel
{
    // phpoffice/phpspreadsheet

    public $spreadsheet;

    public $sheet;

    public function __construct()
    {
        $this->spreadsheet  = new Spreadsheet();
        $this->sheet 		= $this->spreadsheet->getActiveSheet();
    }

    public function autosize($cells)
    {
        $this->sheet
            ->getColumnDimension($cells)
            ->setAutoSize(true);
    }

    public function background($cells, $color)
    {
        $this->sheet
            ->getStyle($cells)
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor($color)
            ->setARGB($color);
    }

    public function bold($cells)
    {
        $this->sheet
            ->getStyle($cells)
            ->getFont()
            ->setBold(true);
    }

    public function color($cells, $color)
    {
        $this->sheet
            ->getStyle($cells)
            ->getFont()
            ->getColor()
            ->setARGB($color);
    }

    public function merge($cells)
    {
        $this->sheet
            ->mergeCells($cells);
    }

    public function size($cells, $size)
    {
        $this->sheet
            ->getStyle($cells)
            ->getFont()
            ->setSize($size);
    }

    public function value($cells, $value)
    {
        $this->sheet
            ->setCellValue($cells, $value);
    }

    public function read($filename)
    {
        $spreadsheet = IOFactory::load($_SERVER['DOCUMENT_ROOT'] . '/' . $filename);
        $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        return $data;
    }

    public function save($path)
    {
        $this->build();

        $writer = new Xlsx($this->spreadsheet);
        $writer->save($_SERVER['DOCUMENT_ROOT'] . '/' . $path);
    }
}
