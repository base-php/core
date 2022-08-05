<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class ClearCache extends Command
{
    protected static $defaultName = 'view:clear';

    protected static $defaultDescription = 'Clear all compiled view files';

    protected function execute($input, $output)
    {
        array_map('unlink', glob('vendor/nisadelgado/framework/cache/*'));

        $style = new SymfonyStyle($input, $output);
        $style->success('Compiled view cleared.');

        return Command::SUCCESS;
    }
}
