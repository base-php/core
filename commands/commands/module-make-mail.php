<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'module:make-mail', description: 'Crea una nueva clase de email en módulo')]
class MakeMail extends Command
{
    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
        $this->addArgument('module', InputArgument::OPTIONAL);

        $this->addOption('test', null, InputOption::VALUE_NONE, 'Genera una clase de prueba adjunta al mail');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $module = $input->getArgument('module');

        if (! $module) {
            if (! file_exists('vendor/base-php/core/tmp/module')) {
                $style->error('No hay ningún módulo seleccionado. Usa el comando module:use para seleccionar un módulo.');
                return Command::FAILURE;
            }

            $module = file_get_contents('vendor/base-php/core/tmp/module');
        }

        while (! $module) {
            $question = new Question("\n- ¿Cuál es el nombre del módulo?\n> ");

            $helper = $this->getHelper('question');
            $module = $helper->ask($input, $output, $question);
        }

        if (! file_exists("modules/$module")) {
            $style->error("El módulo '$module' no existe.");
            return Command::FAILURE;
        }

        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre del mail?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/mail.php');
        $content = str_replace('MailName', $name, $content);
        $content = str_replace('App\Mails', 'Modules\\' . $module . '\Mails', $content);

        if (! file_exists('modules/' . $module . '/Mails')) {
            mkdir('modules/' . $module . '/Mails');
        }

        $fopen = fopen('modules/' . $module . '/Mails/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);
        
        $style->success("Clase de email '$name' creada satisfactoriamente.");

        $test = $input->getOption('test');

        if ($test) {
            $content = file_get_contents('vendor/base-php/core/commands/examples/test.php');
            $content = str_replace('TestName', $name, $content);

            $fopen = fopen('modules/' . $module . '/tests/' . $name . '.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style = new SymfonyStyle($input, $output);
            $style->success("Clase de prueba '$name' creada satisfactoriamente.");
        }

        return Command::SUCCESS;
    }
}
