<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:notification', description: 'Crea una nueva clase de notificación')]
class MakeNotification extends Command
{
    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
        $this->addOption('test', null, InputOption::VALUE_NONE, 'Genera una clase de prueba adjunta a la notificación');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre de la notificación?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/notification.php');
        $content = str_replace('NotificationName', $name, $content);

        if (! file_exists('app/Notifications')) {
            mkdir('app/Notifications');
        }

        $fopen = fopen('app/Notifications/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de notificación '$name' creada satisfactoriamente.");

        $test = $input->getOption('test');

        if ($test) {
            $content = file_get_contents('vendor/base-php/core/commands/examples/test.php');
            $content = str_replace('TestName', $name, $content);

            $fopen = fopen('tests/' . $name . '.php', 'w+');
            fwrite($fopen, $content);
            fclose($fopen);

            $style = new SymfonyStyle($input, $output);
            $style->success("Clase de prueba '$name' creada satisfactoriamente.");
        }

        return Command::SUCCESS;
    }
}
