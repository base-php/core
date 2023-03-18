<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class MigrateStatus extends Command
{
    protected static $defaultName = 'migrate:status';

    protected static $defaultDescription = 'Muestra el estado de cada migración';

    protected function execute($input, $output)
    {
        $style = new SymfonyStyle($input, $output);

        foreach (scandir('database') as $item) {
            if (! is_dir($item)) {
                $name = str_replace('.php', '', $item);

                $exists = DB::connection($class->connection)
                    ->table('migrations')
                    ->where('name', $name)
                    ->get();

                if ($exists->count()) {
                    $style->success($name . ' ejecutada');
                } else {
                    $style->warning($name . ' pendiente');
                }
            }
        }

        return Command::SUCCESS;
    }
}
