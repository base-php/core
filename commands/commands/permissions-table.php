<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class PermissionsTable extends Command
{
    protected static $defaultName = 'permissions:table';

    protected static $defaultDescription = 'Crear migraciones para las tabla de roles y permisos';

    protected function execute($input, $output)
    {
        copy('vendor/base-php/core/packages/permissions/migrations/permissions.php', 'database/'.date('Y_m_d_His') . '_permissions.php');
        copy('vendor/base-php/core/packages/permissions/migrations/roles.php', 'database/'.date('Y_m_d_His') . '_roles.php');
        copy('vendor/base-php/core/packages/permissions/migrations/user_has_roles.php', 'database/'.date('Y_m_d_His') . '_user_has_roles.php');
        copy('vendor/base-php/core/packages/permissions/migrations/role_has_permissions.php', 'database/'.date('Y_m_d_His') . '_role_has_permissions.php');

        $style = new SymfonyStyle($input, $output);
        $style->success('Migración creada satisfactoriamente.');

        return Command::SUCCESS;
    }
}
