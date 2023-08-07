<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConfigShow extends Command
{
    protected static $defaultName = 'config:show';

    protected static $defaultDescription = 'Muestra la información del archivo de configuración';

    protected function execute($input, $output)
    {
        $style = new SymfonyStyle($input, $output);

        $vars = include 'app/config.php';

        foreach ($vars as $key => $value) {
            if (is_array($value)) {
                $value = json($value);
            }

            $config[] = [$key, $value];
        }

        $style->table(
            ['Variable', 'valor'],
            [$config]
        );

        return Command::SUCCESS;
    }
}
