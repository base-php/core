<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Down extends Command
{
    protected static $defaultName = 'down';

    protected static $defaultDescription = 'Poner la aplicación en modo mantenimiento';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = 'app/config.php';

        $string = file_get_contents($file);
        $string = str_replace("'maintenance' => false", "'maintenance' => true", $string);

        $fopen = fopen($file, 'w');
        fwrite($fopen, $string);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->info('La aplicación está ahora en modo mantenimiento.');

        return Command::SUCCESS;
    }
}
