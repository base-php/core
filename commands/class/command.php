<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command as CommandAPI;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

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
        $question = new Question("\n" . $question . "\n> ", $default);
        $helper = $this->getHelper('question');
        return $helper->ask($this->input, $this->output, $question);
    }

    public function choice($question, $options, $default)
    {
        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion(
            $question,
            $options,
            $default
        );

        $question->setErrorMessage('Valor inválido.');
        $question = $helper->ask($this->input, $this->output, $question);
        return $question;
    }

    public function confirm($question, $default = false)
    {
        $question = new ConfirmationQuestion(
            "\n" . $question . "\n> ",
            $default,
            '/^(y|s)/i'
        );

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

    public function error($text)
    {
        $symfonyStyle = new SymfonyStyle($this->input, $this->output);
        return $symfonyStyle->error($text);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
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

    public function info($text)
    {
        $symfonyStyle = new SymfonyStyle($this->input, $this->output);
        return $symfonyStyle->info($text);
    }

    public function line($text)
    {
        $symfonyStyle = new SymfonyStyle($this->input, $this->output);
        return $symfonyStyle->text($text);
    }

    public function newLine($number = 1)
    {
        $symfonyStyle = new SymfonyStyle($this->input, $this->output);
        return $symfonyStyle->newLine($number);
    }

    public function secret($question)
    {
        $helper = $this->getHelper('question');

        $question = new Question("\n" . $question . "\n> ", $default);
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
