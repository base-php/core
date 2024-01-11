<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TokensTable extends Command
{
    protected static $defaultName = 'tokens:table';

    protected static $defaultDescription = 'Crear una migración para la tabla de tokens';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        copy('vendor/base-php/core/packages/tokens/migrations/tokens.php', 'database/' . date('Y_m_d_His') . '_tokens.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Migración creada satisfactoriamente.');

        return Command::SUCCESS;
    }
}
