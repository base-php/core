<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class ViewClear extends Command
{
    protected static $defaultName = 'view:clear';

    protected static $defaultDescription = 'Borra todos los archivos de vista compilados';

    protected function execute($input, $output)
    {
        array_map('unlink', glob('vendor/nisadelgado/framework/cache/*'));

        $style = new SymfonyStyle($input, $output);
        $style->success('Las vistas compiladas se borraron correctamente.');

        return Command::SUCCESS;
    }
}
