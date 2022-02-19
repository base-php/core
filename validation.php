<?php

namespace App\Validations;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory;

class Validation
{
    public $redirect;

    public function __construct()
    {
        return validation(request(), $this->rules(), $this->messages(), $this->redirect);
    }
}
