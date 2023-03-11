<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command as CommandAPI;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

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

        foreach ($this->options() as $item) {
            if ($item['type'] == 'required') {
                $type = InputOption::VALUE_REQUIRED;
            }

            if ($item['type'] == 'optional') {
                $type = InputOption::VALUE_OPTIONAL;
            }

            if ($item['type'] == 'none') {
                $type = InputOption::VALUE_NONE;
            }

            $this->addArgument(
                $item['name'], 
                $item['shortname'], 
                $item['type'], 
                $item['description'], 
                $item['default']
            );
        }
    }

    public function execute($input, $output)
    {
        foreach ($this->params() as $key => $value) {
            $params[$key] = $input->getArgument($key);
        }

        foreach ($this->options() as $item) {
            $options[$item['name']] = $input->getOption($item['name']);
        }

        $params = (object) $params;
        $options = (object) $options;

        $this->handle($params, $options);

        return 1;
    }
}
