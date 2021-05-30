<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel
{
	public $spreadsheet;

	public $sheet;

	public function __construct()
	{
		$this->spreadsheet  = new Spreadsheet();
        $this->sheet 		= $this->spreadsheet->getActiveSheet();
	}

	public function read($filename)
	{
		$spreadsheet = IOFactory::load($_SERVER['DOCUMENT_ROOT'] . '/' . $filename);
        $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        return $data;
	}

	public function color($cells, $color)
	{
		$this->sheet->getStyle($cells)->getFont()->getColor()->setARGB($color);
	}

	public function background($cells, $color)
	{
		$this->sheet->getStyle($cells)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor($color)->setARGB($color);
	}

	public function size($cells, $size)
	{
		$this->sheet->getStyle($cells)->getFont()->setSize($size);
	}

	public function bold($cells)
	{
		$this->sheet->getStyle($cells)->getFont()->setBold(true);
	}

	public function merge($cells)
	{
		$this->sheet->mergeCells($cells);
	}

	public function value($cells, $value)
	{
		$this->sheet->setCellValue($cells, $value);
	}

	public function autosize($cells)
	{
		$this->sheet->getColumnDimension($cells)->setAutoSize(true);
	}

	public function save($filename)
	{
		$writer = new Xlsx($this->spreadsheet);
        $writer->save($_SERVER['DOCUMENT_ROOT'] . '/' . $filename);
	}
}

function excel()
{
	return new Excel();
}
