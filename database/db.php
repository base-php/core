<?php

use Illuminate\Database\Capsule\Manager;

class DB extends Manager
{
	function ask($question)
	{
		if (! class_exists('Doctrine\DBAL\Schema\Schema')) {
			throw new Exception('Please execute `composer require doctrine/dbal`');
		}

		$tables = DB::connection($this->connection)
			->getDoctrineSchemaManager()
			->listTables();

		$structure = '';

		foreach ($tables as $table) {
			$columns = array_keys($table->getColumns());
			$columns = implode(',', $columns);

			$table = $table->getName();

			$structure .= "La tabla '$table' con los campos: '$columns'.\n";
		}

		$prompt = "Mi base de datos tiene la siguiente estructura:\n\n";
		$prompt .= "$structure\n\n";
		$prompt .= "Podrías generar un SQL para '$question'?";

		$openai = openai()->chat($prompt);

		$explode = explode('```', $openai);
		$sql = $explode[1];

		return $this->select($this->raw($sql));
	}
}
