<?php

namespace App\Resources;

class Resource
{
    public function __construct($data)
    {
        $paginate = 0;

        if (gettype($data) == 'object') {
            if (strpos(get_class($data), 'Models') || get_class($data) == 'Illuminate\Database\Eloquent\Collection' || get_class($data) == 'Illuminate\Pagination\LengthAwarePaginator') {
                if (get_class($data) == 'Illuminate\Pagination\LengthAwarePaginator') {
                    $paginate = 1;
                }

                $data = $data->toArray();
            }
        }

        // For various records.

        if (isset($data[0]) || isset($data['data'])) {
            $i = 0;

            if ($paginate) {
                foreach ($data['data'] as $item) {
                    foreach ($item as $key => $value) {
                        $this->$key = $value;
                    }

                    foreach ($this->array() as $key => $value) {
                        $this->result[$i][$key] = $value;
                        unset($this->$key);
                    }

                    $this->result['data'][$i] = (object) $this->result[$i];

                    $i = $i + 1;
                }

                $this->result['links'] = $data['links'];

                $this->result['meta'] = [
                    'current_page' => $data['current_page'],
                    'from' => $data['from'],
                    'last_page' => $data['last_page'],
                    'path' => $data['path'],
                    'per_page' => $data['per_page'],
                    'to' => $data['to'],
                    'total' => $data['total'],
                ];

            } else {
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

            if (isset($this->wrap)) {
                $this->result = [
                    $this->wrap => $this->result
                ];
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

    public function __toString()
    {
        return json($this->result);
    }

    public function when($condition, $variable)
    {
        if ($condition) {
            return $variable;
        }
    }
}
