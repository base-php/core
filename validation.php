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
					$model = 'App\Models\\' . $unique;

					if (request('id')) {
						$id = request('id');
						$query = $model::where($key, $_POST[$key])
							->where('id', '!=', $id)
							->get();
					} else {
						$query = $model::where($key, $_POST[$key])
							->get();
					}

					if ($query->count()) {
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

				if (strpos($validation, 'after') !== false) {
					$date = explode(':', $validation);
					$date_valiation = strtotime($date[1]);
					$date_user = strtotime($_POST[$key]);

					if ($date_user <= $date_valiation) {
						$errors[] = $class->messages()[$key . '.after'];
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

				if (strpos($validation, 'num') !== false) {
					if (!is_numeric($_POST[$key])) {
						$errors[] = $class->messages()[$key . '.num'];
					}
				}

				if (strpos($validation, 'num_min') !== false) {
					$num = explode(':', $validation);
					$num_validation = $num[1];
					$num_user = $_POST[$key];

					if ($num_user >= $num_validation) {
						$errors[] = $class->messages()[$key . '.num_min'];
					}
				}

				if (strpos($validation, 'num_max') !== false) {
					$num = explode(':', $validation);
					$num_validation = $num[1];
					$num_user = $_POST[$key];

					if ($num_user <= $num_validation) {
						$errors[] = $class->messages()[$key . '.num_max'];
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
