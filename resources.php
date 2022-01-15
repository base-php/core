<?php

namespace App\Resources;

class Resource
{
    public function __construct($data)
    {
        if (gettype($data) == 'object') {
            if (strpos(get_class($data), 'Models') || get_class($data) == 'Illuminate\Database\Eloquent\Collection') {
                $data = $data->toArray();
            }
        }

        // For various records.

        if (isset($data[0])) {
            $i = 0;

            foreach ($data as $item) {
                foreach ($item as $key => $value) {
                    $this->$key = $value;
                }

                foreach ($this->array() as $key => $value) {
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

            foreach ($this->array() as $key => $value) {
                $this->result[$key] = $value;
                unset($this->$key);
            }
        }
    }
}