<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'module:migrate-reset', description: 'Revertir todas las migraciones de un módulo específico')]
class ModuleMigrateReset extends Command
{
    public function configure()
    {
        $this->addArgument('module', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $module = $input->getArgument('module');

        if (! $module) {
            if (! file_exists('vendor/base-php/core/tmp/module')) {
                $style->error('No hay ningún módulo seleccionado. Usa el comando module:use para seleccionar un módulo.');
                return Command::FAILURE;
            }

            $module = file_get_contents('vendor/base-php/core/tmp/module');
        }

        while (! $module) {
            $question = new Question("\n- ¿Cuál es el nombre del módulo?\n> ");

            $helper = $this->getHelper('question');
            $module = $helper->ask($input, $output, $question);
        }

        if (! file_exists("modules/$module")) {
            $style->error("El módulo '$module' no existe.");
            return Command::FAILURE;
        }
        
        require 'vendor/base-php/core/database/database.php';

        $config = require 'app/config.php';

        $migrations = DB::table('migrations')
            ->orderByDesc('batch')
            ->get();

        foreach ($migrations as $migration) {
            try {
                $require = 'modules/' . $module . '/database/' . $migration->name . '.php';

                if (! file_exists($require)) {
                    continue;
                }

                $class = require $require;
                $class->down();

                DB::table('migrations')
                    ->where('id', $migration->id)
                    ->delete();

                $style->warning($migration->name);
            } catch (Exception $exception) {
                $style->error($exception->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
