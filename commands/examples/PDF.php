<?php

namespace App\PDF;

use View;

class PDFName extends PDF
{
	/**
     * Determines if the page orientation will be horizontal or not.
     *
     * $var bool
     */
	public bool $lanscape = false;

	/**
     * Create a new message instance.
     *
     * @return void
     */
	public function __construct()
	{
		
	}

	/**
     * View of the generated PDF.
     *
     * @return View
     */
	public function build(): View
	{
		return view();
	}
}
