<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeMail extends Command
{
    protected static $defaultName = 'make:mail';

    protected static $defaultDescription = 'Create a mail with the given name';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Mail.php');
        $content = str_replace('MailName', $name, $content);

        if (!file_exists('app/Mails')) {
        	mkdir('app/Mails');
        }

        $fopen = fopen('app/Mails/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Mail '$name' created successfully.");

        return Command::SUCCESS;
    }
}
