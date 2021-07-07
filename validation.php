<?php

namespace App\Validations;

use Illuminate\Database\Capsule\Manager as DB;

/**
 * Base class for validations.
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
			$_SESSION['flashmessages']['inputs'] = $_POST;

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

				if (strpos($validation, 'before') !== false) {
					$date = explode(':', $validation);
					$date_valiation = strtotime($date[1]);
					$date_user = strtotime($_POST[$key]);

					if ($date_user >= $date_valiation) {
						$errors[] = $class->messages()[$key . '.before'];
					}
				}

				if (strpos($validation, 'before_or_equal') !== false) {
					$date = explode(':', $validation);
					$date_valiation = strtotime($date[1]);
					$date_user = strtotime($_POST[$key]);

					if ($date_user > $date_valiation) {
						$errors[] = $class->messages()[$key . '.before_or_equal'];
					}
				}

				if (strpos($validation, 'after') !== false) {
					$date = explode(':', $validation);
					$date_valiation = strtotime($date[1]);
					$date_user = strtotime($_POST[$key]);

					if ($date_user <= $date_valiation) {
						$errors[] = $class->messages()[$key . '.after'];
					}
				}

				if (strpos($validation, 'after_or_equal') !== false) {
					$date = explode(':', $validation);
					$date_valiation = strtotime($date[1]);
					$date_user = strtotime($_POST[$key]);

					if ($date_user < $date_valiation) {
						$errors[] = $class->messages()[$key . '.after_or_equal'];
					}
				}

				if (strpos($validation, 'between') !== false) {
					$dates = explode(':', $validation);
					$dates = explode(',', $dates[1]);

					$start = strtotime($dates[0]);
					$end = strtotime($dates[1]);

					$date_user = strtotime($_POST[$key]);

					if ($date_user < $start || $date_user > $end) {
						$errors[] = $class->messages()[$key . '.between'];
					}
				}

				if (strpos($validation, '()') !== false) {
					$function = str_replace('()', '', $validation);

					$rule = $class->$function($key, $_POST[$key]);

					if (!$rule) {
						$errors[] = $class->messages()[$key . '.' . $function];
					}
				}
			}
		}

		$_SESSION['flashmessages']['errors'] = $errors;
		$_SESSION['flashmessages']['input'] = $_POST;

		if (!empty($errors)) {
			redirect($_SERVER['HTTP_REFERER']);
			return exit;
		}
	}
}
