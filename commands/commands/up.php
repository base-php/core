<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'up', description: 'Sacar la aplicación del modo de mantenimiento')]
class Up extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = 'app/config.php';

        $string = file_get_contents($file);
        $string = str_replace("'maintenance' => true", "'maintenance' => false", $string);

        $fopen = fopen($file, 'w');
        fwrite($fopen, $string);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->info('La aplicación ahora está activa.');

        return Command::SUCCESS;
    }
}
