<?php

namespace App\Validations;

class Validation
{
    public $redirect;

    public function __construct()
    {
        return validation(request(), $this->rules(), $this->messages(), $this->redirect);
    }
}
