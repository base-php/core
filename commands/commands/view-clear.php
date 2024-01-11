<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ViewClear extends Command
{
    protected static $defaultName = 'view:clear';

    protected static $defaultDescription = 'Borra todos los archivos de vista compilados';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        array_map('unlink', glob('vendor/base-php/core/cache/*'));

        $style = new SymfonyStyle($input, $output);
        $style->success('Las vistas compiladas se borraron correctamente.');

        return Command::SUCCESS;
    }
}
