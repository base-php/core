<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class DBWipe extends Command
{
    protected static $defaultName = 'db:wipe';

    protected static $defaultDescription = 'Eliminar todas las tablas, vistas y tipos';

    public function configure()
    {
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'Conexión de base de datos a utilizar', 'default');
    }

    protected function execute($input, $output)
    {
        include 'vendor/base-php/core/database/database.php';

        $connection = $input->getOption('database');

        $tables = DB::connection($connection)
            ->select('SHOW FULL TABLES');

        foreach ($tables as $table) {
            $item = $table->Table_type == 'VIEW' ? 'VIEW' : 'TABLE';

            DB::connection($connection)
                ->statement("DROP $item $table->Tables_in_base");
        }

        $style = new SymfonyStyle($input, $output);
        $style->info('Se eliminaron todas las tablas exitosamente.');

        return Command::SUCCESS;
    }
}
