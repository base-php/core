<?php

namespace App\Validations;

use Illuminate\Database\Capsule\Manager as DB;

/**
 * Base class for validations
 */
class Validation
{
	/**
     * Run the defined validations.
     *
     * @return redirect\void
     */
	public static function validate()
	{
		$class = new static();

		$errors = [];

		foreach ($class->rules() as $key => $value) {
			$validations = explode('|', $value);


			foreach ($validations as $validation) {				
				if ($validation == 'required') {
					if (!isset($_POST[$key]) || $_POST[$key] == '') {
						$errors[] = $class->messages()[$key . '.required'];
					}
				}

				if ($validation == 'email') {
					if (!filter_var($_POST[$key], FILTER_VALIDATE_EMAIL)) {
						$errors[] = $class->messages()[$key . '.email'];
					}
				}

				if (strpos($validation, 'min') !== false) {
					$min = explode(':', $validation);
					$min = $min[1];

					if (strlen($_POST[$key]) < $min) {
						$errors[] = $class->messages()[$key . '.min'];
					}
				}

				if (strpos($validation, 'max') !== false) {
					$max = explode(':', $validation);
					$max = $max[1];

					if (strlen($_POST[$key]) > $max) {
						$errors[] = $class->messages()[$key . '.max'];
					}
				}

				if (strpos($validation, 'unique') !== false) {
					$unique = explode(':', $validation);
					$unique = $unique[1];

					if (post('id')) {
						$id = post('id');
						$query = DB::select("SELECT * FROM $unique WHERE $key = '$_POST[$key]' AND id != '$id'");
					} else {
						$query = DB::select("SELECT * FROM $unique WHERE $key = '$_POST[$key]'");
					}

					if ($query) {
						$errors[] = $class->messages()[$key . '.unique'];
					}
				}

				if (strpos($validation, 'same') !== false) {
					$same = explode(':', $validation);
					$same = $same[1];

					if ($_POST[$key] != $_POST[$same]) {
						$errors[] = $class->messages()[$key . '.same'];
					}
				}
			}
		}

		$_SESSION['flashmessages']['errors'] = $errors;
		$_SESSION['flashmessages']['errors']['input'] = $_POST;

		if (!empty($errors)) {
			redirect($_SERVER['HTTP_REFERER']);
			return exit;
		}
	}
}
