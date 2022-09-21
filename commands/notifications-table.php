<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class NotificationsTable extends Command
{
    protected static $defaultName = 'notifications:table';

    protected static $defaultDescription = 'Crear una migración para la tabla de notificaciones';

    protected function execute($input, $output)
    {
        copy('vendor/base-php/core/commands/migrations/1647519970_notifications.php', 'database/1647519970_notifications.php');

        $style = new SymfonyStyle($input, $output);
        $style->success("Migración creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
