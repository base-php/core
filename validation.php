<?php

namespace App\Validations;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory;

class Validation
{
    public $connection = 'default';

    public function __construct()
    {
        include 'database.php';

        $files      = new Filesystem();
        $loader     = new FileLoader($files, '');
        $translator = new Translator($loader, 'es');
        $factory    = new Factory($translator);

        $verifier = new DatabasePresenceVerifier($capsule->getDatabaseManager($this->connection));

        $factory->setPresenceVerifier($verifier);

        $validation = $factory->make(request(), $this->rules(), $this->messages());

        if ($validation->errors()->all()) {
            $errors = $validation->errors()->all();

            $_SESSION['flashmessages']['errors'] = $errors;
            $_SESSION['flashmessages']['input']  = request();

            redirect($_SERVER['HTTP_REFERER']);
            return exit;
        }
    }
}
