<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'module:migrate', description: 'Ejecuta las migraciones de base de datos de un módulo específico')]
class ModuleMigrate extends Command
{
    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $name = $input->getArgument('name');

        if (! $name) {
            if (! file_exists('vendor/base-php/core/tmp/module')) {
                $stlye->error('No hay ningún módulo seleccionado. Usa el comando module:use para seleccionar un módulo.');
                return Command::FAILURE;
            }

            $name = file_get_contents('vendor/base-php/core/tmp/module');
        }

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre del módulo?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        if (! file_exists("modules/$name")) {
            $style->error("El módulo '$name' no existe.");
            return Command::FAILURE;
        }
        
        foreach (scandir("modules/$name/database") as $item) {
            if (! is_dir($item)) {
                $require = "modules/$name/database/$item";

                $name = str_replace('.php', '', $item);

                if (pathinfo($require)['extension'] == 'sqlite') {
                    continue;
                }

                $class = require $require;

                if (isset($class->connection)) {
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
        }

        return Command::SUCCESS;
    }
}
