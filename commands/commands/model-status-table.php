<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class ModelStatusTable extends Command
{
    protected static $defaultName = 'model-status:table';

    protected static $defaultDescription = 'Crear una migración para la tabla de estados de modelos';

    protected function execute($input, $output)
    {
        copy('vendor/base-php/core/packages/model-status/migrations/model-status.php', 'database/' . date('Y_m_d_His') . '_logs.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Migración creada satisfactoriamente.');

        return Command::SUCCESS;
    }
}
