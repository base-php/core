<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'bills:table', description: 'Crear migraciones para las tablas de facturación')]
class BillsTable extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        copy('vendor/base-php/core/packages/bill/migrations/customers.php', 'database/' . date('Y_m_d_His') . '_customers.php');
        sleep(1);

        copy('vendor/base-php/core/packages/bill/migrations/bills.php', 'database/' . date('Y_m_d_His') . '_bills.php');
        sleep(1);

        copy('vendor/base-php/core/packages/bill/migrations/bills_items.php', 'database/' . date('Y_m_d_His') . '_bills_items.php');
        sleep(1);

        $style = new SymfonyStyle($input, $output);
        $style->success('Miraciones creadas satisfactoriamente.');

        return Command::SUCCESS;
    }
}
