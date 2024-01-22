<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'config:show', description: 'Muestra la información del archivo de configuración')]
class ConfigShow extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
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
