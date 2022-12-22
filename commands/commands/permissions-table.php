<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class PermissionsTable extends Command
{
    protected static $defaultName = 'permissions:table';

    protected static $defaultDescription = 'Crear migraciones para las tabla de roles y permisos';

    protected function execute($input, $output)
    {
        copy('vendor/base-php/core/permissions/migrations/1665158907_permissions.php', 'database/1665158907_permissions.php');
        copy('vendor/base-php/core/permissions/migrations/1665159481_roles.php', 'database/1665159481_roles.php');
        copy('vendor/base-php/core/permissions/migrations/1665159625_user_has_roles.php', 'database/1665159625_user_has_roles.php');
        copy('vendor/base-php/core/permissions/migrations/1665159717_role_has_permissions.php', 'database/1665159717_role_has_permissions.php');

        $style = new SymfonyStyle($input, $output);
        $style->success("Migración creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
