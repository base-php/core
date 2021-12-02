<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command as CommandAPI;
use Symfony\Component\Console\Input\InputArgument;

class Command extends CommandAPI
{
    public function __construct()
    {
        $this->setName($this->name);
        $this->setDescription($this->description);

        parent::__construct();
    }

    public function configure()
    {
        foreach ($this->params() as $key => $value) {
            $value = ($value == 'required') ? InputArgument::REQUIRED : InputArgument::OPTIONAL;
            $this->addArgument($key, $value);
        }
    }

    public function execute($input, $output)
    {
        foreach ($this->params() as $key => $value) {
            $params[$key] = $input->getArgument($key);
        }

        $params = (object) $params;

        $this->handle($params);

        return 1;
    }
}
