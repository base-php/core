<?php

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
     * @return void
     */
	public function __construct()
	{
		$this->spreadsheet  = new Spreadsheet();
        $this->sheet 		= $this->spreadsheet->getActiveSheet();
	}

	/**
     * Read data from Excel file.
     *
     * @param $filename string
     * @return array
     */
	public function read($filename)
	{
		$spreadsheet = IOFactory::load($_SERVER['DOCUMENT_ROOT'] . '/' . $filename);
        $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        return $data;
	}

	/**
     * Set color to cell.
     *
     * @param $cells string
     * @param $color string
     * @return void
     */
	public function color($cells, $color)
	{
		$this->sheet->getStyle($cells)->getFont()->getColor()->setARGB($color);
	}

	/**
     * Set background color to cell.
     *
     * @param $cells string
     * @param $color string
     * @return void
     */
	public function background($cells, $color)
	{
		$this->sheet->getStyle($cells)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor($color)->setARGB($color);
	}

	/**
     * Set font size to cell.
     *
     * @param $cells string
     * @param $size string
     * @return void
     */
	public function size($cells, $size)
	{
		$this->sheet->getStyle($cells)->getFont()->setSize($size);
	}

	/**
     * Set font bold to cell.
     *
     * @param $cells string
     * @return void
     */
	public function bold($cells)
	{
		$this->sheet->getStyle($cells)->getFont()->setBold(true);
	}

	/**
     * Merge cells.
     *
     * @param $cells string
     * @return void
     */
	public function merge($cells)
	{
		$this->sheet->mergeCells($cells);
	}

	/**
     * Set value to cell.
     *
     * @param $cells string
     * @param $value string
     * @return void
     */
	public function value($cells, $value)
	{
		$this->sheet->setCellValue($cells, $value);
	}

	/**
     * Redimension size to cell.
     *
     * @param $cells string
     * @return void
     */
	public function autosize($cells)
	{
		$this->sheet->getColumnDimension($cells)->setAutoSize(true);
	}

	/**
     * Save Excel file.
     *
     * @param $filename string
     * @return void
     */
	public function save($filename)
	{
		$writer = new Xlsx($this->spreadsheet);
        $writer->save($_SERVER['DOCUMENT_ROOT'] . '/' . $filename);
	}
}

/**
 * Initialize global helper.
 *
 * @return Excel
 */
function excel()
{
	return new Excel();
}
