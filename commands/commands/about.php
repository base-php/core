<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'about', description: 'Muestra información básica sobre tu aplicación')]
class About extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $config = include 'app/config.php';

        $composer = exec('composer --version');
        $composer = explode(' ', $composer);
        $composer = $composer[2];

        $errors = ($config['errors']) ? 'ACTIVO' : 'INACTIVO';

        $databases = implode(',', array_column($config['database'], 'driver'));

        $style->table(
            [],
            [
                ['Nombre de la aplicación', $config['application_name']],
                ['Versión de BasePHP', $config['version']],
                ['Versión de PHP', phpversion()],
                ['Versión de Composer', $composer],
                ['Entorno', $config['environment']],
                ['Errores', $errors],
                ['Bases de datos', $databases],
            ]
        );

        return Command::SUCCESS;
    }
}
