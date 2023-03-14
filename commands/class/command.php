<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command as CommandAPI;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;

class Command extends CommandAPI
{
    public $input;
    public $output;

    public function __construct()
    {
        $this->setName($this->name);
        $this->setDescription($this->description);

        parent::__construct();
    }

    public function ask($question, $default)
    {
        $question = new Question($question, $default);
        $helper = $this->getHelper('question');
        return $helper->ask($this->input, $this->output, $question);
    }

    public function configure()
    {
        foreach ($this->args() as $key => $value) {
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
        foreach ($this->args() as $key => $value) {
            $args[$key] = $input->getArgument($key);
        }

        foreach ($this->options() as $item) {
            $options[$item['name']] = $input->getOption($item['name']);
        }

        $args = $this->args() ? (object) $args : (object) [];
        $options = $this->args() ? (object) $options : (object) [];

        $this->input = $input;
        $this->output = $output;

        $this->handle($args, $options);

        return 1;
    }

    public function secret($question)
    {
        $helper = $this->getHelper('question');

        $question = new Question($question, $default);
        $question->setHidden(true);
        $question->setHiddenFallback(false);

        return $helper->ask($this->input, $this->output, $question);
    }

    public function table($headers, $rows)
    {
        $table = new Table($this->output);
        $table->setHeaders($headers);
        $table->setBody($rows);
        $table->render();
    }
}
