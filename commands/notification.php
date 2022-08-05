<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeNotification extends Command
{
    protected static $defaultName = 'make:notification';

    protected static $defaultDescription = 'Create a notificacion with the given name';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Notification.php');
        $content = str_replace('NotificationName', $name, $content);

        if (!file_exists('app/Notifications')) {
            mkdir('app/Notifications');
        }

        $fopen = fopen('app/Notifications/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Notification '$name' created successfully.");

        return Command::SUCCESS;
    }
}
