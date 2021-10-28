<?php

namespace App\Excel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
* Read/write Excel file, require phpoffice/phpspreadsheet package.
*/
class Excel
{
	/**
	* Main instance.
	*
	* $spreadsheet object
	*/
	public $spreadsheet;

	/**
	* Main woorksheet.
	*
	* $sheet object
	*/
	public $sheet;

	/**
	* Initialize the class to use from a global function.
	*
	*/
	public function __construct()
	{
		$this->spreadsheet  = new Spreadsheet();
		$this->sheet 		= $this->spreadsheet->getActiveSheet();
	}

	/**
	* Redimension size to cell.
	*
	* @param $cells string
	* @return void
	*/
	public function autosize(string $cells): void
	{
		$this->sheet
			->getColumnDimension($cells)
			->setAutoSize(true);
	}

	/**
	* Set background color to cell.
	*
	* @param $cells string
	* @param $color string
	* @return void
	*/
	public function background(string $cells, string $color): void
	{
		$this->sheet
			->getStyle($cells)
			->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor($color)
			->setARGB($color);
	}

	/**
	* Set font bold to cell.
	*
	* @param $cells string
	* @return void
	*/
	public function bold(string $cells): void
	{
		$this->sheet
			->getStyle($cells)
			->getFont()
			->setBold(true);
	}

	/**
	* Set color to cell.
	*
	* @param $cells string
	* @param $color string
	* @return void
	*/
	public function color(string $cells, string $color): void
	{
		$this->sheet
			->getStyle($cells)
			->getFont()
			->getColor()
			->setARGB($color);
	}

	/**
	* Merge cells.
	*
	* @param $cells string
	* @return void
	*/
	public function merge(string $cells): void
	{
		$this->sheet
			->mergeCells($cells);
	}

	/**
	* Set font size to cell.
	*
	* @param $cells string
	* @param $size string
	* @return void
	*/
	public function size(string $cells, string $size): void
	{
		$this->sheet
			->getStyle($cells)
			->getFont()
			->setSize($size);
	}

	/**
	* Set value to cell.
	*
	* @param $cells string
	* @param $value string
	* @return void
	*/
	public function value(string $cells, string $value): void
	{
		$this->sheet
			->setCellValue($cells, $value);
	}

	/**
	* Read data from Excel file.
	*
	* @param $filename string
	* @return array
	*/
	public function read(string $filename): array
	{
		$spreadsheet = IOFactory::load($_SERVER['DOCUMENT_ROOT'] . '/' . $filename);
		$data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		return $data;
	}

	/**
	* Save Excel file in given path.
	*
	* @param $path string
	* @return void
	*/
	public function save(string $path): void
	{
		$this->build();

		$writer = new Xlsx($this->spreadsheet);
		$writer->save($_SERVER['DOCUMENT_ROOT'] . '/' . $path);
	}
}
