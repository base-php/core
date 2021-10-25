<?php

namespace App\Resources;

class Resource
{
	public function __construct($data)
	{
		// For various records
		if (isset($data[0])) {
			$i = 0;

			foreach ($data as $item) {
				foreach ($item as $key => $value) {
					$this->$key = $value;
				}

				foreach ($this->build() as $key => $value) {
					$this->result[$i][$key] = $value;
					unset($this->$key);
				}

				$this->result[$i] = (object) $this->result[$i];

				$i = $i + 1;
			}
		}

		// For one record.

		else {
			foreach ($data as $key => $value) {
				$this->$key = $value;
			}

			foreach ($this->build() as $key => $value) {
				$this->result[$key] = $value;
				unset($this->$key);
			}

			$this->result = (object) $this->result;			
		}
	}
}