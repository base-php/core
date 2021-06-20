<?php

namespace App\PDF;

class PDFName extends PDF
{
	/**
     * Determines if the page orientation will be horizontal or not.
     *
     * $var boolean
     */
	public $lanscape = false;

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
     * @return void
     */
	public function build()
	{
		return view();
	}
}
