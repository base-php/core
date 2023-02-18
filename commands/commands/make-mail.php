<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeMail extends Command
{
    protected static $defaultName = 'make:mail';

    protected static $defaultDescription = 'Crea una nueva clase de email';

    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre del mail?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/mail.php');
        $content = str_replace('MailName', $name, $content);

        if (! file_exists('app/Mails')) {
            mkdir('app/Mails');
        }

        $fopen = fopen('app/Mails/'.$name.'.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de email '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
