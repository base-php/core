<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class VisitsTable extends Command
{
    protected static $defaultName = 'visits:table';

    protected static $defaultDescription = 'Crear migración para tabla de visitas';

    protected function execute($input, $output)
    {
        copy('vendor/base-php/core/packages/visits/migrations/visits.php', 'database/' . date('Y_m_d_His').'_visits.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Migraciones creadas satisfactoriamente.');

        return Command::SUCCESS;
    }
}
