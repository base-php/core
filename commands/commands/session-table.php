<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class SessionTable extends Command
{
    protected static $defaultName = 'session:table';

    protected static $defaultDescription = 'Crear una migración para la tabla de sesiones';

    protected function execute($input, $output)
    {
        copy('vendor/base-php/core/support/migrations/sessions.php', 'database/'.date('Y_m_d_His').'_sessions.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Migración creada satisfactoriamente.');

        return Command::SUCCESS;
    }
}
