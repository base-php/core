<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'module:list', description: 'Listado de todos los módulos')]
class ModuleList extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        if (! is_dir('modules')) {
            $style->error('No hay módulos instalados.');
            return Command::FAILURE;
        }

        $modules = scandir('modules');
        $modules = array_splice($modules, 2);

        $body = [];

        foreach ($modules as $module) {
            if (is_dir('modules/'.$module)) {
                $body[] = [
                    $module,
                    __DIR__ . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module,
                    'ACTIVO',
                ];
            }
        }

        if (empty($body)) {
            $style->error('No hay módulos instalados.');
            return Command::FAILURE;
        }

        $style->table(
            ['Nombre', 'Ruta', 'Estado'],
            $body
        );

        return Command::SUCCESS;
    }
}
