<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'session:table', description: 'Crear una migración para la tabla de sesiones')]
class SessionTable extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        copy('vendor/base-php/core/support/migrations/sessions.php', 'database/'.date('Y_m_d_His').'_sessions.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Migración creada satisfactoriamente.');

        return Command::SUCCESS;
    }
}
