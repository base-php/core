<?php

use Symfony\Component\Console\Command\Command;

class ClearCache extends Command
{
    protected static $defaultName = 'view:clear';

    protected static $defaultDescription = 'Clear all compiled view files';

    protected function execute($input, $output)
    {
        array_map('unlink', glob('vendor/nisadelgado/framework/cache/*'));

        $text = "<info>Compiled view cleared!</info>";
        $output->writeln($text);

        return Command::SUCCESS;
    }
}
