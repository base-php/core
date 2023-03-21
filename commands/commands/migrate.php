<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class Migrate extends Command
{
    protected static $defaultName = 'migrate';

    protected static $defaultDescription = 'Ejecuta las migraciones de base de datos';

    public function configure()
    {
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'Conexión de base de datos a utilizar', 'default');
        $this->addOption('path', null, InputOption::VALUE_REQUIRED, 'Ruta al archivo de migración que se ejecutará');
    }

    protected function execute($input, $output)
    {
        $style = new SymfonyStyle($input, $output);

        $connection = $input->getOption('database');

        foreach (scandir('database') as $item) {
            if (! is_dir($item)) {
                $require = $input->getOption('path') ? $item : 'database/' . $item;

                $name = str_replace('.php', '', $item);

                $class = require $require;

                $exists = DB::connection($class->connection)
                    ->table('migrations')
                    ->where('name', $name)
                    ->get();

                if ($exists->count()) {
                    continue;
                }

                try {
                    $class->up();

                    $batch = DB::connection($class->connection)
                        ->table('migrations')
                        ->max('batch');

                    $batch++;

                    DB::connection($class->connection)
                        ->table('migrations')
                        ->insert([
                            'name' => $name,
                            'batch' => $batch,
                        ]);

                    $style->success($item);
                } catch (Exception $exception) {
                    $style->error($exception->getMessage());
                }
            }
        }

        return Command::SUCCESS;
    }
}
