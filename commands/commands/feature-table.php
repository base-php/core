<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class FeatureTable extends Command
{
    protected static $defaultName = 'feature:table';

    protected static $defaultDescription = 'Crear una migración para la tabla de features';

    protected function execute($input, $output)
    {
        copy('vendor/base-php/core/feature/migrations/features.php', 'database/'.date('Y_m_d_His').'_features.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Migración creada satisfactoriamente.');

        return Command::SUCCESS;
    }
}
