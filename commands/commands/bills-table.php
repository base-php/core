<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class BillsTable extends Command
{
    protected static $defaultName = 'bills:table';

    protected static $defaultDescription = 'Crear migraciones para las tablas de facturación';

    protected function execute($input, $output)
    {
        copy('vendor/base-php/core/bill/migrations/customers.php', 'database/'.date('Y_m_d_His').'_customers.php');
        copy('vendor/base-php/core/bill/migrations/bills.php', 'database/'.date('Y_m_d_His').'_bills.php');
        copy('vendor/base-php/core/bill/migrations/bills_items.php', 'database/'.date('Y_m_d_His').'_bills_items.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Miraciones creadas satisfactoriamente.');

        return Command::SUCCESS;
    }
}
