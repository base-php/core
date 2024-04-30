<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'cart:table', description: 'Crear migraciones para las tablas de carrito de compra')]
class CartTable extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        copy('vendor/base-php/core/support/migrations/cart.php', 'database/' . date('Y_m_d_His') . '_cart.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Miraciones creadas satisfactoriamente.');

        return Command::SUCCESS;
    }
}
