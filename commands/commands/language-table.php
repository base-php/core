<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'language:table', description: 'Crear una migración para la tabla de traducción')]
class LanguageTable extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        copy('vendor/base-php/core/packages/language/migrations/language.php', 'database/' . date('Y_m_d_His') . '_language.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Migración creada satisfactoriamente.');

        return Command::SUCCESS;
    }
}
