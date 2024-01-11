<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeCommand extends Command
{
    protected static $defaultName = 'make:command';

    protected static $defaultDescription = 'Crea una nueva clase de comando';

    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
        $this->addOption('command', null, InputOption::VALUE_NONE, 'El comando de terminal al que será asignado [default: "command:name"]');
        $this->addOption('test', null, InputOption::VALUE_NONE, 'Genera una clase de prueba adjunta al controlador');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre del comando?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/command.php');
        $content = str_replace('CommandName', $name, $content);

        $command = $input->getOption('command');

        if ($command) {
            $content = str_replace('public string $name = \'\';', 'public string $name = \'' . $name . '\';', $content);
        }

        if (! file_exists('app/Commands')) {
            mkdir('app/Commands');
        }

        $fopen = fopen('app/Commands/'.$name.'.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de comando '$name' creada satisfactoriamente.");

        $test = $input->getOption('test');

        if ($test) {
            $content = file_get_contents('vendor/base-php/core/commands/examples/test.php');
            $content = str_replace('TestName', $name, $content);

            $fopen = fopen('tests/'.$name.'.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style = new SymfonyStyle($input, $output);
            $style->success("Clase de prueba '$name' creada satisfactoriamente.");
        }

        return Command::SUCCESS;
    }
}
